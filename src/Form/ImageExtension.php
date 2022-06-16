<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageExtension extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        // this defines the available options and their default values when
        // they are not configured explicitly when using the form type
        $resolver->setDefaults([
            'is_extended' => false,
        ]);

        $resolver->setAllowedTypes('is_extended', 'bool');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // pass the form type option directly to the template
        $view->vars['isExtended'] = $options['is_extended'];
    }

    public function getParent()
    {
        return HiddenType::class;
    }
}