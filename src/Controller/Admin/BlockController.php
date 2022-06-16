<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use App\Entity\BlockField;
use App\Form\BlockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/block")
 */
class BlockController extends AbstractController
{
    /**
     * @Route("/", name="admin_block_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $blocks = $entityManager
            ->getRepository(Block::class)
            ->findAll();

        return $this->render('admin/block/index.html.twig', [
            'blocks' => $blocks,
        ]);
    }

    /**
     * @Route("/new", name="admin_block_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $block = new Block();
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $block->setCreatedAt(new \DateTime());
            $entityManager->persist($block);
            $entityManager->flush();

            return $this->redirectToRoute('admin_block_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block/new.html.twig', [
            'block' => $block,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_block_show", methods={"GET"})
     */
    public function show(Block $block): Response
    {
        return $this->render('admin/block/show.html.twig', [
            'block' => $block,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_block_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Block $block, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlockType::class, $block);
        $form->handleRequest($request);

        $blockFields = $entityManager
            ->getRepository(BlockField::class)
            ->findBy(array('block'=>$block));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_block_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/block/edit.html.twig', [
            'block' => $block,
            'form' => $form->createView(),
            'blockFields' => $blockFields
        ]);
    }

    /**
     * @Route("/{id}", name="admin_block_delete", methods={"POST"})
     */
    public function delete(Request $request, Block $block, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$block->getId(), $request->request->get('_token'))) {
            $entityManager->remove($block);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_block_index', [], Response::HTTP_SEE_OTHER);
    }
}
