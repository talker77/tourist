<?php


namespace App\Controller\Admin;

use App\Entity\Attraction;
use App\Entity\Block;
use App\Entity\Category;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\Review;
use App\Form\AttractionType;
use App\Form\BlogType;
use App\Form\DocumentBlockDataType;
use App\Form\DocumentType;
use App\Form\GenericBlockType;
use App\Form\GenericType;
use App\Service\AttractionService;
use App\Service\UploadService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Class BlogController
 * @package App\Controller\Admin
 * @Route("/admin/document")
 */
class DocumentController extends AbstractController
{

    /**
     * @Route("/", name="admin_document_index")
     * @Template()
     */
    public function index(Request $request)
    {
        $docs = $this->getDoctrine()->getRepository(Document::class)->findAll();

        return array('docs'=>$docs);
    }

    /**
     * @Route("/new", name="admin_document_new")
     * @Template()
     */
    public function new(Request $request)
    {
        $document =new Document();
        $form = $this->createForm(DocumentType::class,$document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_document_index');
        }

        return array('document'=>$document,'form'=>$form->createView());
    }

    /**
     * @Route("/edit/{document}", name="admin_document_edit")
     * @Template()
     */
    public function edit(Request $request,Document $document)
    {
        $form = $this->createForm(DocumentType::class,$document);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_document_index');
        }

        $blocks = $document->getBlocks();


        return array('document'=>$document,'form'=>$form->createView(),'blocks'=>$blocks);
    }


    /**
     * @Route("/save-block/{document}-{block}", name="admin_document_block_save")
     * @Template()
     */
    public function saveBlock(Request $request,Document $document,Block $block,UploadService $uploadService)
    {
        $url =   $this->generateUrl('admin_document_block_save', array('block'=>$block->getId(),'document'=>$document->getId()));
        $dform = $this->createForm(GenericBlockType::class,null,array('document'=>$document,'block'=>$block,'action'=>$url));


        $dform->handleRequest($request);
        if ($dform->isSubmitted() && $dform->isValid()) {


            foreach($dform->getData() as $name => $entity)
            {

                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();
            }

            return $this->redirectToRoute('admin_document_edit',array('document'=>$document->getId()));
        }

        return array('form' => $dform->createView(),'block'=> $block);

    }




}