<?php


namespace App\Service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use DrewM\MailChimp\MailChimp;
use Psr\Container\ContainerInterface;

class MailChimpService
{
    private $container;
    private $mailChimp;
    private $entityManager;


    public function __construct(ContainerInterface $container, EntityManagerInterface $entityManagerInterface)
    {
        $this->container = $container;
        $this->entityManager = $entityManagerInterface;
        $this->mailChimp = new MailChimp($this->container->getParameter('mailchimp_key'), null);

    }


    public function emailSubscribe($email){
        $result = $this->mailChimp->put("/lists/".$this->container->getParameter('mailchimp_listid')."/members/".$this->emailhash($email), [
            'email_address' => $email,
            'status'        => 'subscribed',
            'interests'=>array(
                '4e7e734a9b' => true
            ),
            'tags'=> array(
                'ITP_Email_Sub'
            )
        ]);

        return $result;
    }

    public function addInterest($title){
        $result = $this->mailChimp->post("/lists/".$this->container->getParameter('mailchimp_listid')."/interest-categories", [
            'title' => $title,
            'type' => 'checkboxes'
        ]);

        return $result;
    }

    public function addTag($title){
        $result = $this->mailChimp->post("/lists/".$this->container->getParameter('mailchimp_listid')."/segments", [
            'name' => $title,
            'static_segment' => []
        ]);

        return $result;
    }

    private function emailhash($email){
         return md5(strtolower('zugbaba@homtmi.com'));
    }
}