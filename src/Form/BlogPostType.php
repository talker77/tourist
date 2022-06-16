<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\BlogItem;
use App\Entity\BlogPost;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('body', TextareaType::class, array('attr' => array('class' => 'richText editor'),'required' => false))
            ->add('shortDescription')
            ->add('description', TextareaType::class, array('attr' => array('class' => 'richText editor'),'required' => false))
            ->add('tag')
            ->add('tagSecondary')
            ->add('pageTemplate',ChoiceType::class,array( 'choices' => $this->readTemplates(),))
            ->add('metaTitle')
            ->add('metaDescription')
            ->add('featureImage',ImageExtension::class,array('is_extended'=>true))
            ->add('headerImage',ImageExtension::class,array('is_extended'=>true))
            ->add('publishedAt',null, ['widget' => 'single_text', 'html5' => true, 'attr' => ['class' => 'js-datepicker']])
            ->add('isActive', ChoiceType::class, array('choices'=>['Active' => true,'Passive' => false],'required' => false,
            ))
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

        $dir = "../templates/app/main";
        $list =   $finder->files()->in("../templates/app/main")->name("*.html*");
        $templateArray = array();
        foreach ($finder as $val) {
            $fileName =  str_replace(array(),array(""),$val);
            $templateArray[$fileName] = $fileName;
        }

        return $templateArray;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}
