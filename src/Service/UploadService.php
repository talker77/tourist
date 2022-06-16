<?php

namespace App\Service;

use App\Utility\StringUtility;
use Aws\S3\S3Client;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class UploadService
{

    /**
     * @var ParameterBagInterface
     */
    private $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public  $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    );

    public function s3fileUpload(UploadedFile $file,$targetFolder)
    {

        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => $this->parameterBag->get('aws_region'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => $this->parameterBag->get('aws_key'),
                'secret' => $this->parameterBag->get('aws_secret'),
            ],
        ]);

        $bucketName = $this->parameterBag->get('aws_bucket_name');
        $aws = $s3->putObject(
            array(
                'Bucket' => $bucketName,
                'Key' => $targetFolder,
                'ContentType' => $file->getMimeType(),
                'Body' => file_get_contents($file->getPathname())
            )
        );

        return $this->replaceCdnUrl($aws['ObjectURL']);
    }

    public function upload(UploadedFile $file,$title =null,$path = "doc")
    {

        if (null === $file) {
            return;
        }

        if (!in_array($file->getClientMimeType(), $this->allowedMimeTypes)) {
            throw new \InvalidArgumentException(sprintf('Files of type %s are not allowed.', $file->getClientMimeType()));
        }

        if(!$title) $title = md5(time());
        $fileName = StringUtility::slugify($title)."-".uniqid();
        $folderPath = $this->parameterBag->get('items_folder')."/$path";
        $targetFolder = $folderPath."/".$fileName.".".$file->getClientOriginalExtension();

        return $this->s3fileUpload($file,$targetFolder);
    }

    private function replaceCdnUrl($url)
    {
        return $url;
        $explodeUrl = explode('.com',$url);
        $cdnUrl = $this->parameterBag->get('cdn_url');
        return $cdnUrl.$explodeUrl[1];
    }







}