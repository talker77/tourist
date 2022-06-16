<?php

namespace App\Controller\Admin;

use App\Entity\Navigation;
use App\Entity\NavigationItem;
use App\Form\NavigationItem1Type;
use App\Repository\NavigationItemRepository;
use App\Service\NavigationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/navigation/item")
 */
class NavigationItemController extends AbstractController
{


    /**
     * @Route("/new/{navigation}", name="navigation_item_new", methods={"GET","POST"})
     */
    public function new(Request $request,Navigation $navigation,NavigationService $navigationService,NavigationItemRepository $navigationItemRepository): Response
    {
        $navigationItem = new NavigationItem();
        $navigationItem->setNavigation($navigation);
        if($request->query->get('parent'))
        {
            $parent = $navigationItemRepository->find($request->query->get('parent'));
            $navigationItem->setParent($parent);
            $navigationItem->setNavigation($parent->getNavigation());
        }

        $form = $this->createForm(NavigationItem1Type::class, $navigationItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($navigationItem);
            $entityManager->flush();

            $navigationService->reGenerateTree($navigationItem->getNavigation());

            return $this->redirectToRoute('navigation_edit',array('id'=>$navigationItem->getNavigation()->getId()));
        }

        return $this->render('admin/navigation_item/new.html.twig', [
            'navigation_item' => $navigationItem,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/move_item", name="navigation_move_item", methods={"GET","POST"})
     */
    public function moveItem(Request $request,NavigationService $navigationService): Response
    {

         $res = $navigationService->moveItem($request->get('id'),$request->get('parent'),$request->get('position'));

         return new JsonResponse($res->getId());
    }



    /**
     * @Route("/{id}/edit", name="navigation_item_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NavigationItem $navigationItem,NavigationService $navigationService): Response
    {

        $breadcrumb[] =  array(
            'isActive' => false, 'name' => "Navigations",'link'=> $this->generateUrl('navigation_index',array('id'=>$navigationItem->getNavigation()->getId()))
        );

        $breadcrumb[] =  array(
            'isActive' => false, 'name' => $navigationItem->getNavigation()->getName(),'link'=> $this->generateUrl('navigation_edit',array('id'=>$navigationItem->getNavigation()->getId()))
        );

        $breadcrumb[] =  array(
            'isActive' => true, 'name' => $navigationItem->getName(),'link'=> '#'
        );



        if($request->get('locale')) {
            $em = $this->getDoctrine()->getManager();
            $navigationItem->setTranslatableLocale($request->get('locale'));
            $em->refresh($navigationItem);
        }

        $form = $this->createForm(NavigationItem1Type::class, $navigationItem,array(
            'action' => $this->generateUrl('navigation_item_edit', array('id' => $navigationItem->getId(), 'locale' => $request->get('locale'))
            )));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $navigationService->reGenerateTree($navigationItem->getNavigation());


            return $this->redirectToRoute('navigation_item_edit',array('id'=>$navigationItem->getId()));
        }

        return $this->render('admin/navigation_item/edit.html.twig', [
            'navigation_item' => $navigationItem,
            'form' => $form->createView(),
            'breadcrumb'=>$breadcrumb
        ]);
    }

    /**
     * @Route("/{id}", name="navigation_item_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NavigationItem $navigationItem,NavigationService $navigationService): Response
    {
        $navigation = $navigationItem->getNavigation();
        if ($this->isCsrfTokenValid('delete'.$navigationItem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($navigationItem);
            $entityManager->flush();

            $navigationService->reGenerateTree($navigationItem->getNavigation());
        }

        return $this->redirectToRoute('navigation_edit',array('id'=>$navigation->getId()));

    }
}
