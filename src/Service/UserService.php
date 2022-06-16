<?php


namespace App\Service;


use App\Entity\Attraction;
use App\Entity\User;
use App\Utility\StringUtility;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $container;
    private $entityManager;
    private $flashBag;
    private $userPasswordEncoder;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface, FlashBagInterface $flashBag, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->flashBag = $flashBag;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    public function saveUser(Request $request, User $user){
        $em = $this->entityManager;
        $encoded = $this->userPasswordEncoder->encodePassword($user, $user->getPassword());

        $user->setRoles([$request->get('roles')]);
        $user->setPassword($encoded);

        $em->persist($user);
        $em->flush();
        $this->flashBag->add('success', "Success!! User Created");
    }

}