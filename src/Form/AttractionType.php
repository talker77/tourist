<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AttractionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('badge', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('googleMap', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('embedMap', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('rating', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('review', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('ranking', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('passPrice', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('showOnHome', NumberType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('admission', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('hours', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('gettingThere', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('remark', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('price', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('videoUrl', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('dipNote', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('bannerText', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('aboutTour', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('AdvantagesText', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('learnMore', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('sortingIndex', NumberType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('lat', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('lng', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('metaTitle', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('metaDescription', TextareaType::class, array(
                'attr' => array('class' => 'form-control editor'),
                'required' => false
            ))
            ->add('days', TextType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'placeholder' => 'Choose an Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'title',
                'attr' => array(
                    'class' => 'custom-select'
                )
            ))
            ->add('videoCover', FileType::class, array(
                'mapped' => false,
                'attr' => array(
                    'class' => 'custom-file-input'
                ),
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ))
            ->add('thumbnail', FileType::class, array(
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'custom-file-input'
                    ),
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid Image document',
                        ])
                    ],
                )

            )
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => Attraction::class
        ]);
    }

    public function getBlockPrefix()
    {
    }
}
