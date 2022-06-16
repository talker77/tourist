<?php


namespace App\Service\Api;


use App\Entity\Attraction;
use App\Entity\AttractionImage;
use App\Entity\FaqQuestionCategory;
use App\Repository\FaqQuestionCategoryRepository;
use App\Repository\StaticDataRepository;
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

class StaticService
{


    /**
     * @var StaticDataRepository
     */
    private $staticDataRepository;

    public function __construct(StaticDataRepository $staticDataRepository)
    {
        $this->staticDataRepository = $staticDataRepository;
    }


    public function getList()
    {
        $statics = array();
        $rows = $this->staticDataRepository->findAll();
        foreach($rows as $static)
        {
            $statics[$static->getCategory()][] =array($static->getKey()=>$static->getValue());
        }

        return $statics;

    }

}