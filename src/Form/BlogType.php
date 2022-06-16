<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('shortDescription')
            ->add('description')
            ->add('pageTemplate',ChoiceType::class,array( 'choices' => $this->readTemplates(),))

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $blog = $event->getData();
            $form = $event->getForm();

            // checks if the Product object is "new"
            // If no data is passed to the form, the data is "null".
            // This should be considered a new "Product"
            if ($blog->getId()) {
                $form->add('slug');
            }
        });
    }

    private function readTemplates()
    {
        $finder = new Finder();

        $dir = "../";
        $list =   $finder->files()->in("../")->name("blog_*");
        $templateArray = array();
        foreach ($finder as $val) {
            $fileName =  str_replace(array($dir,".html.twig"),array("",""),$val);
            $templateArray[$fileName] = $fileName;
        }

        return $templateArray;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
