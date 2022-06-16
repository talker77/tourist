<?php


namespace App\Service;


use App\Entity\Attraction;
use App\Entity\FaqQuestion;
use App\Entity\FaqQuestionCategory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class FaqService
{
    private $container;
    private $entityManager;
    private $flashBag;
    private $attractionImageService;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface, FlashBagInterface $flashBag, AttractionImageService $attractionImageService)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->flashBag = $flashBag;
        $this->attractionImageService = $attractionImageService;
    }


    public function newQuestion($questionAnswer){
        try{
            $em = $this->entityManager;
            $newQuestion = new FaqQuestion();
            $category = $em->getRepository(FaqQuestionCategory::class)->find($questionAnswer['categoryId']);
            $newQuestion->setQuestion($questionAnswer['question']);
            $newQuestion->setAnswer($questionAnswer['answer']);
            $newQuestion->setCategory($category);
            $newQuestion->setCreatedAt(new \DateTime());
            $em->persist($newQuestion);
            $em->flush();
        }catch (EntityNotFoundException $exception){
            $this->flashBag('error', $exception->getMessage());
        }
    }

    public function addQuestionCategory($categoryName){
        try{
            $em = $this->entityManager;
            $newQuestionCategory = new FaqQuestionCategory();
            $newQuestionCategory->setTitle($categoryName);
            $em->persist($newQuestionCategory);
            $em->flush();
        }catch (EntityNotFoundException $exception){
            $this->flashBag('error', $exception->getMessage());
        }
    }

    public function saveFaq(Request $request){
        $em = $this->entityManager;
        $questionsRepo = $em->getRepository(FaqQuestion::class);
        $questionsCategoryRepo = $em->getRepository(FaqQuestionCategory::class);
        try{
            $faqs = $request->get('faq')['questions'];
            $faqsCategory = $request->get('faq')['category'];
            foreach ($faqs as $id => $value){
                $question = $questionsRepo->find($id);
                $question->setAnswer($value['answer']);
                $question->setQuestion($value['question']);
                $em->persist($question);
            }
            foreach ($faqsCategory as $id => $value){
                $questionCategory = $questionsCategoryRepo->find($id);
                $questionCategory->setTitle($value);
                $em->persist($questionCategory);
            }
            $this->flashBag->add('success', "Saved");
            $em->flush();
        }catch (Exception $exception){

        }

    }

    public function removeCategory(FaqQuestionCategory $faqQuestionCategory){
        $em = $this->entityManager;
        try{
            foreach ($faqQuestionCategory->getQuestions() as $question){
                $question->setDeletedAt(new \DateTime());
                $em->persist($question);
            }
            $faqQuestionCategory->setDeleteAt(new \DateTime());
            $em->persist($faqQuestionCategory);
            $em->flush();
            return true;
        }catch (EntityNotFoundException $exception){
            return false;
        }

    }

}