<?php


namespace App\Service;


use App\Entity\Attraction;
use App\Entity\AttractionImage;
use App\Utility\StringUtility;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use DrewM\MailChimp\MailChimp;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class AttractionImageService
{
    private const SERVER_PATH_TO_THUMBNAIL_FOLDER = 'app/img/inclusions/thumbnails';
    private const SERVER_PATH_TO_VIDEOCOVER_FOLDER = 'app/img/videocover';
    private $container;
    private $entityManager;
    private $attractionImageUploadService;
    /**
     * @var UploadService
     */
    private $uploadService;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface, AttractionImageUploadService $attractionImageUploadService,UploadService $uploadService)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->attractionImageUploadService = $attractionImageUploadService;

        $this->uploadService = $uploadService;
    }

    public function uploadAttractionImages(Request $request,Attraction $attraction)
    {

        $em =$this->entityManager;

        if($request->files->get("photo")) {

            $position = count($attraction->getImages());

            foreach($request->files->get("photo") as $file)
            {
                if($file) {
                    $position++;

                    list($width, $height, $type, $attr)  = $this->IsImage($file);

                    if ($width > 3000 || $height > 3000) {
                        return false;
                    }

                    $imageUrl =  $this->uploadService->upload($file,$attraction->getTitle(),"attraction");
                    $productImage = new AttractionImage();
                    $productImage->setAttraction($attraction);
                    $productImage->setSrc($imageUrl);
                    $productImage->setPosition($position);
                    $productImage->upload();
                    $productImage->setCreatedAt(new \DateTime());
                    $em->persist($productImage);
                }

            }
            $em->flush();
        }
        return $attraction;
    }

    function IsImage($path)
    {
        $a = getimagesize($path);
        $image_type = $a[2];

        if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
        {
            return $a;
        }

        throw new UnprocessableEntityHttpException('Image is not validated ');
    }

    public function attractionVideoCoverUpload(UploadedFile $file, Attraction $attraction)
    {
        if (null === $file && !$this->IsImage($file)) {
            return;
        }
        $newFileName = StringUtility::urlSlugify($attraction->getTitle().rand(0,999999)).'.'.$file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $url = self::SERVER_PATH_TO_VIDEOCOVER_FOLDER.'/'.$newFileName;
            $file->move(
                self::SERVER_PATH_TO_VIDEOCOVER_FOLDER,
                $newFileName
            );
            return $url;
        } catch (FileException $e) {
            throw new FileException($e);
        }
    }
    public function attractionThumbnailUpload(UploadedFile $file, Attraction $attraction)
    {
        if (null === $file && !$this->IsImage($file)) {
            return;
        }
        $newFileName = StringUtility::urlSlugify($attraction->getTitle().rand(0,999999)).'.'.$file->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $url = self::SERVER_PATH_TO_THUMBNAIL_FOLDER.'/'.$newFileName;
            $file->move(
                self::SERVER_PATH_TO_THUMBNAIL_FOLDER,
                $newFileName
            );
            return $url;
        } catch (FileException $e) {
           throw new FileException($e);
        }
    }
}