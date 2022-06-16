<?php


namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Service\UserService;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/**
 * Class DashboardController
 * @package App\Controller\Admin
 * @Route("/admin/account")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("/", name="admin_account_list")
     * @Template("admin/account/index.html.twig")
     */
    public function index(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->getDatatableData();

        return array('users'=>$users);
    }

    /**
     * @Route("/add", name="admin_account_add")
     * @Template("admin/account/addUser.html.twig")
     */
    public function createUser(Request $request, UserService $userService)
    {
        $userEntity = new User();
        $form = $this->createForm(UserType::class, $userEntity);

        if ($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted() and $form->isValid()){
                $userService->saveUser($request, $userEntity);
                $this->addFlash('success', 'User added!');
                return $this->redirectToRoute('admin_account_list');
            }else{
                $this->addFlash('error', 'Please check the form');
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/role/togglerole/{user}", name="admin_account_role_toggle")
     *
     */
    public function toggleRole(Request $request, UserManagerInterface $userManagerInterface, User $user)
    {
        try{
            $user = $userManagerInterface->findUserBy(['id'=>$user->getId()]);
            if(in_array('ROLE_ADMIN',$user->getRoles())){
                $user->removeRole('ROLE_ADMIN');
            }else{
                $user->addRole('ROLE_ADMIN');
            }
            $userManagerInterface->updateUser($user);
            $this->addFlash('success','Role Changed');
        }catch (Exception $exception){
            $this->addFlash('success',$exception->getMessage());
        }
        return $this->redirectToRoute('admin_account_list');
    }

    /**
     * @Route("/statusToggle/{user}", name="admin_account_status_toggle")
     *
     */
    public function toggleStatus(Request $request, UserManagerInterface $userManagerInterface, User $user)
    {
        try{
            $user = $userManagerInterface->findUserBy(['id'=>$user->getId()]);
            if($user->isEnabled()){
                $user->setEnabled(false);
            }else{
                $user->setEnabled(true);
            }
            $this->addFlash('success','Status Changed');
            $userManagerInterface->updateUser($user);
        }catch (Exception $exception){
            $this->addFlash('success',$exception->getMessage());
        }
        return $this->redirectToRoute('admin_account_list');
    }

}