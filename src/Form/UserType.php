<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 
            TextType::class, 
                array('attr' => array('class' => 'form-control')
            ))
            ->add('email', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('enabled', ChoiceType::class, array(
                'choices'=>[
                  'Enable' => true,
                  'Disable' => false
                ],
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('password', PasswordType::class, array(
                'attr' => array('class' => 'form-control disabled')
            ))
            ->add('roles', ChoiceType::class, array(
                'mapped'=>false,
                'choices'=>[
                    'USER' => 'ROLE_USER',
                    'ADMIN' => 'ROLE_ADMIN'
                ],
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => User::class
        ]);
    }

    public function getBlockPrefix()
    {
    }
}
