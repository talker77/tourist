<?php


namespace App\Service;


use App\Utility\StringUtility;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttractionImageUploadService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    private  $allowedMimeTypes = array(
        'image/jpeg',
        'image/png',
        'image/gif'
    );


    




}