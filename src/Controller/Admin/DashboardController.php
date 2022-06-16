<?php


namespace App\Controller\Admin;

use App\Entity\Attraction;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Review;
use App\Entity\User;
use App\Service\GlobalService;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_main")
     * @Template("admin/main/index.html.twig")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine();
        $attractionCount = $em->getRepository(Attraction::class)->count([]);
        $reviewCount = $em->getRepository(Review::class)->count([]);
        return array(
            'attractionCount' => $attractionCount,
            'reviewCount' => $reviewCount
        );
    }
//
//    /**
//     * @Route("/login", name="ajax_login_user")
//     *
//     */
//    public function loginUserAction(Request $request)
//    {
//dump('sa');
//die();
//    }


}