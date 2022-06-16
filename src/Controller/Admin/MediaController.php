<?php

namespace App\Controller\Admin;

use App\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin")
 */
class MediaController extends AbstractController
{

    /**
     * @Route("/image-upload", name="admin_media_image_upload", methods={"POST"})
     * @Template()
     */
    public function imageUpload(Request $request,UploadService $uploadService)
    {
        $imagePath = $uploadService->upload($request->files->get("file"));
        return new JsonResponse(array('name' => $imagePath));

    }

}
