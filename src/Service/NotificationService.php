<?php


namespace App\Service;

use App\Entity\ContactFormItem;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class NotificationService
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var EntityManager */
    private $em;

    /** @var \Swift_Mailer */
    private $mailer;


    public function __construct(ContainerInterface $container,\Swift_Mailer $mailer)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
        $this->mailer =$mailer;
    }



    public function send($subject, $body, $recipient, $bcc = array())
    {

        $message = (new \Swift_Message($subject))
            ->setTo($recipient)
            ->setFrom($this->container->getParameter('mail_sender_address'))
            ->setReplyTo('contact@istanbultouristpass.com', 'Istanbul Tourist Pass Contact')
            ->setBody(
                $body,
                'text/html'
            )
            ->addBcc('contact@istanbultouristpass.com')
            ->addBcc('noreply@istanbultouristpass.com');


        if ($bcc && count($bcc)) {
            foreach ($bcc as $c) {
                $message->addBcc($c);
            }
        }
        $res = $this->mailer->send($message);



        return $res;
    }


    public function sendMessage($renderedTemplate, $recipient, $cc = array())
    {

        $renderedLines = explode("\n", trim($renderedTemplate));

        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $this->send($subject, $body, $recipient, $cc);

        return true;
    }


    private function renderTemplate($templateName, $TemplateVariables = array())
    {
        return $this->container->get('twig')->render('mail/' . $templateName . ".html.twig", $TemplateVariables);
    }


    public function sendVendorUserWelcomeMail(ContactFormItem $contactform,$cc = array())
    {
        $template = "contact_form";
        $rendered = $this->renderTemplate($template,
            array(
                'contact' => $contactform
            )
        );

        return $this->sendMessage($rendered, $this->container->getParameter('admin_mail'),$cc);
    }







}
