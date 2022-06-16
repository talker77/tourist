<?php

namespace App\Form;

use App\Entity\NavigationItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NavigationItem1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('document')
            ->add('name')
            ->add('url')
            ->add('target')
            ->add('extraClass')
            ->add('parent')
            ->add('order')
            ->add('rollOverTitle')
            ->add('rollOverLabel')
            ->add('subtitle')
            ->add('description')
            ->add('banner',ImageExtension::class, ['label' => 'banner', 'required' => false, 'is_extended' => true])
            ->add('bannerLabel')
            ->add('bannerLink')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NavigationItem::class,
        ]);
    }
}
