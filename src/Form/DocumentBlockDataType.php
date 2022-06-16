<?php

namespace App\Form;

use App\Entity\DocumentBlockData;
use Gedmo\Mapping\Driver\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;



class DocumentBlockDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options){
            $documentBlockType = $event->getData();
            $form = $event->getForm();

            $fieldType = $documentBlockType->getBlockFieldType();
            $field = $documentBlockType->getBlockField();
            if ($fieldType == "TextType") {
                $form->add('content', TextType::class, ['label' => $field->getLabel(), 'required' => false]);
            }

            if ($fieldType == "TextareaType") {
                $form->add('content', TextareaType::class, ['label' => $field->getLabel(), 'required' => false, 'attr' => ['class' => 'richText editor']]);
            }

            if ($fieldType== "ImageExtension") {
                $form->add('content', ImageExtension::class, ['label' => $field->getLabel(), 'required' => false,'data_class'=>null,'is_extended'=>true]);
           //     $form->add('oldContent', HiddenType::class, ['label' => $field->getLabel(), 'required' => false]);
            }

            if ($fieldType == "RichText") {
                $form->add('content', TextareaType::class, ['label' => $field->getLabel(), 'required' => false, 'attr' => ['class' => 'richText editor']]);
            }

            if ($fieldType == "DateType") {
                $form->add('content', DateType::class, [
                    'label' => $field->getLabel(),
                    'years' => range(2000, (int)date('Y')+5),
                    'required' => false]);
            }


            if($options['addOption']) {
                $form->add('blockField', null);
                $form->add('content', null);
            }


        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => DocumentBlockData::class,
            'addOption' => false,
        ]);
    }
}
