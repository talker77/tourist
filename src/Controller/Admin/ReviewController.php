<?php


namespace App\Controller\Admin;

use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin/review")
 */
class ReviewController extends AbstractController
{

    /**
     * @Route("/", name="admin_review")
     * @Template("admin/review/index.html.twig")
     */
    public function index(Request $request)
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->getDatatableData();

        return array('reviews'=>$reviews);
    }

    /**
     * @Route("/statusToggle/{review}", name="admin_review_status_toggle")
     *
     */
    public function toggleStatus(Request $request, Review $review)
    {
        $em = $this->getDoctrine()->getManager();
        try{
            $review =  $em->getRepository(Review::class)->find(['id'=>$review->getId()]);
            if($review->getisActive()){
                $review->setisActive(false);
            }else{
                $review->setisActive(true);
            }
            $this->addFlash('success','Status Changed');
            $em->flush();
        }catch (Exception $exception){
            $this->addFlash('success',$exception->getMessage());
        }
        return $this->redirectToRoute('admin_review');
    }

}