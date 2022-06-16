<?php

namespace App\Controller\Admin;

use App\Entity\BlockFieldType;
use App\Form\BlockFieldTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/block/field/type")
 */
class BlockFieldTypeController extends AbstractController
{
    /**
     * @Route("/", name="block_field_type_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $blockFieldTypes = $entityManager
            ->getRepository(BlockFieldType::class)
            ->findAll();

        return $this->render('admin/block_field_type/index.html.twig', [
            'block_field_types' => $blockFieldTypes,
        ]);
    }

    /**
     * @Route("/new", name="block_field_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $blockFieldType = new BlockFieldType();
        $form = $this->createForm(BlockFieldTypeType::class, $blockFieldType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blockFieldType);
            $entityManager->flush();

            return $this->redirectToRoute('block_field_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block_field_type/new.html.twig', [
            'block_field_type' => $blockFieldType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="block_field_type_show", methods={"GET"})
     */
    public function show(BlockFieldType $blockFieldType): Response
    {
        return $this->render('admin/block_field_type/show.html.twig', [
            'block_field_type' => $blockFieldType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="block_field_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BlockFieldType $blockFieldType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlockFieldTypeType::class, $blockFieldType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('block_field_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block_field_type/edit.html.twig', [
            'block_field_type' => $blockFieldType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="block_field_type_delete", methods={"POST"})
     */
    public function delete(Request $request, BlockFieldType $blockFieldType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blockFieldType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($blockFieldType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('block_field_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
