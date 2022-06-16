<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use App\Entity\BlockField;
use App\Form\BlockFieldType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/block/field")
 */
class BlockFieldController extends AbstractController
{

    /**
     * @Route("/new/{block}", name="admin_block_field_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,Block $block): Response
    {
        $blockField = new BlockField();
        $blockField->setBlock($block);
        $blockField->setCreatedAt(new \DateTime());
        $form = $this->createForm(BlockFieldType::class, $blockField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blockField);
            $entityManager->flush();

            return $this->redirectToRoute('admin_block_edit', ['id'=>$block->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block_field/new.html.twig', [
            'block_field' => $blockField,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="admin_block_field_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BlockField $blockField, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlockFieldType::class, $blockField);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_block_edit', ['id'=>$blockField->getBlock()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block_field/edit.html.twig', [
            'block_field' => $blockField,
            'block' =>$blockField->getBlock(),
            'form' => $form->createView(),
        ]);
    }

}
