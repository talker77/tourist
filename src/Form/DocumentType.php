<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\Document;
use App\Entity\User;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pageName', TextType::class, array('attr' => array('class' => 'form-control')));
        $builder->add('metaTitle', TextType::class, array('attr' => array('class' => 'form-control')));
        $builder->add('metaDescription', TextType::class, array('attr' => array('class' => 'form-control')));
        $builder->add('handle', null, array('attr' => array('class' => 'form-control')));
        $builder->add('body', null, array('attr' => array('class' => 'form-control')));
        $builder->add('title1', null, array('attr' => array('class' => 'form-control')));
        $builder->add('title2', null, array('attr' => array('class' => 'form-control')));
        $builder->add('title3', null, array('attr' => array('class' => 'form-control')));
        $builder->add('template', ChoiceType::class,array( 'choices' => $this->readTemplates()));
        $builder->add('blocks', null,     array(
            'expanded' => true,
            'attr' => array('class' => 'multipleExpanded'),
            'required' => false,
        ));


    }

    private function readTemplates()
    {
        $finder = new Finder();

        $dir = "../templates/app/main";
        $finder->files()->in($dir)->name("*.html.twig");
        $templateArray = array();
        foreach ($finder as $val) {
            $fileName =  str_replace(array($dir),array(""),$val);
            $templateArray[$fileName] = $fileName;
        }

        return $templateArray;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => Document::class
        ]);
    }
}
