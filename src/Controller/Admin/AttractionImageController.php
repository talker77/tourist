<?php


namespace App\Controller\Admin;

use App\Entity\Attraction;
use App\Entity\AttractionImage;
use App\Service\AttractionImageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin/attraction/image")
 */
class AttractionImageController extends AbstractController
{
    /**
     * @Route("/upload-attraction-image/{attraction}", name="admin_attraction_image_upload")
     */
    public function uploadItemImageAction(Request $request, Attraction $attraction, AttractionImageService $attractionImageService)
    {

        $files = $attractionImageService->uploadAttractionImages($request, $attraction);
        if ($files) {
            $this->addFlash('success', "Image upload success!!");

            if ($request->get('referer')) return $this->redirect($request->get('referer'));
        } else {
            $this->addFlash('error', 'Görsel boyutu çok büyük; Lütfen küçülterek tekrar deneyiniz.');
        }

        return $this->redirectToRoute('admin_attraction_edit', array('attraction' => $attraction->getId()));

    }

    /**
     * @Route("/delete-image/{image}", name="admin_delete_attraction_image")
     */
    public function deleteItemImageAction(Request $request, AttractionImage $image)
    {
        $em = $this->getDoctrine()->getManager();
        $image->setDeletedAt(new \DateTime());
        $em->persist($image);
        $em->flush();
        return $this->redirectToRoute('admin_attraction_edit', array('attraction' => $image->getAttraction()->getId()));
    }

    /**
     * @Route("/set-image-position", name="admin_set_image_position")
     */
    public function setImagePositionAction(Request $request)
    {
        try {
        $em = $this->getDoctrine()->getManager();
        $attractionImages = $this->getDoctrine()->getRepository(AttractionImage::class);
            $imagePositions = $request->get('imagePosition');
            foreach ($imagePositions as $id => $position) {
                $image = $attractionImages->find($id);
                $image->setPosition($position);
                $em->persist($image);
            }
            $em->flush();
            return new JsonResponse(['status' => 'success'], 200);
        } catch (Exception $e) {
            return new JsonResponse(['status' => $e->getMessage()], 500);
        }
    }


}