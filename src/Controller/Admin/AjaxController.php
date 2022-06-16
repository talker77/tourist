<?php


namespace App\Controller\Admin;

use App\Entity\User;
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
 * @Route("/ajax")
 */
class AjaxController extends AbstractController
{

    /**
     * @Route("/register", name="ajax_register")
     *
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @return Response
     */
    public function addUserAction(Request $request, UserManagerInterface $userManager)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {

            $post = $request->request->all();
            $userName = $post['username'];
            $email = $post['email'];
            $password = $post['password'];

            if (!empty($userManager->findUserByEmail($email)) || !empty($userManager->findUserByUsername($userName))) {
                return new JsonResponse(array('success' => false, 'message' => 'Email/Username Already registered'));
            } else {

                $user = $userManager->createUser();
                $user->setEnabled(true);
                $user->setEmail($email);
                $user->setEmailCanonical($email);
                $user->setUsername($userName);
                $user->setUsernameCanonical($userName);
                $user->setPlainPassword($password);

                $userManager->updateUser($user);

                $em->persist($user);
                $em->flush();

                if ($user instanceof User) {
                    $targetUrl = $this->generateUrl('homepage');
                    return new JsonResponse(['targetUrl' => $targetUrl]);
                }
            }
        }
        return new JsonResponse('failure');
    }


}