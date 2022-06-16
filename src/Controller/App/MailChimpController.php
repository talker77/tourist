<?php

namespace App\Controller\App;

use App\Service\MailChimpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/mailchimp")
 *
 */
class MailChimpController extends AbstractController
{
    /**
     * @Route("/subscribe", name="mc_subscribe")
     * @Template()
     */
    public function index(Request $request,MailChimpService $mailChimpService)
    {
        $email = $request->get('email');
        $mailchimpResult = $mailChimpService->emailSubscribe($email);

        return new JsonResponse($mailchimpResult);
    }

    /**
     * @Route("/openinterest", name="mc_interest")
     * @Template()
     */
    public function openInterest(MailChimpService $mailChimpService)
    {
        $response = $mailChimpService->addInterest('ITP_Email_Sub');
        return new JsonResponse();
    }
    /**
     * @Route("/opentag", name="mc_tag")
     * @Template()
     */
    public function openTag(MailChimpService $mailChimpService)
    {
        $response = $mailChimpService->addTag('ITP_Email_Sub');
        dump($response);
        die();
        return new JsonResponse();
    }

}

