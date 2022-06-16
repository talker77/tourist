<?php

namespace App\Controller\Admin;

use App\Entity\StaticData;
use App\Form\StaticDataType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/staticdata")
 */
class StaticDataController extends AbstractController
{
    /**
     * @Route("/", name="static_data_index", methods={"GET"})
     */
    public function index(): Response
    {
        $staticDatas = $this->getDoctrine()
            ->getRepository(StaticData::class)
            ->findAll();

        return $this->render('admin/static_data/index.html.twig', [
            'static_datas' => $staticDatas,
        ]);
    }

    /**
     * @Route("/new", name="static_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $staticDatum = new StaticData();
        $form = $this->createForm(StaticDataType::class, $staticDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staticDatum);
            $entityManager->flush();

            return $this->redirectToRoute('static_data_index');
        }

        return $this->render('admin/static_data/new.html.twig', [
            'static_datum' => $staticDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="static_data_show", methods={"GET"})
     */
    public function show(StaticData $staticDatum): Response
    {
        return $this->render('admin/static_data/show.html.twig', [
            'static_datum' => $staticDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="static_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StaticData $staticDatum): Response
    {
        $form = $this->createForm(StaticDataType::class, $staticDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('static_data_index');
        }

        return $this->render('admin/static_data/edit.html.twig', [
            'static_datum' => $staticDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="static_data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, StaticData $staticDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staticDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staticDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('static_data_index');
    }
}
