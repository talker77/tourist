<?php


namespace App\Service\Api;


use App\Entity\Attraction;
use App\Entity\AttractionImage;
use App\Entity\FaqQuestionCategory;
use App\Repository\FaqQuestionCategoryRepository;
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

class FaqService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var FaqQuestionCategoryRepository
     */
    private $faqQuestionCategoryRepository;

    public function __construct(EntityManagerInterface $em,FaqQuestionCategoryRepository $faqQuestionCategoryRepository)
    {
        $this->em = $em;
        $this->faqQuestionCategoryRepository = $faqQuestionCategoryRepository;
    }


    public function getList()
    {
        $dataArray = array();
        $faqCategories = $this->faqQuestionCategoryRepository->findAll();
        foreach($faqCategories as $faqCategory)
        {
            $items = array();
            foreach($faqCategory->getQuestions() as $question)
            {
                $items[]= array('id'=>$question->getId(),'title'=>$question->getQuestion(),'answer'=>$question->getAnswer());

            }

            $dataArray[] = array('section_title' =>$faqCategory->getTitle() ,'items'=>$items);
        }


        return $dataArray;
    }

}