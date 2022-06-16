<?php

namespace App\Form;

use App\Entity\Attraction;
use App\Entity\Block;
use App\Entity\BlockField;
use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenericBlockType extends AbstractType
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $block = $options['block'];
        $document = $options['document'];
        $block = $this->entityManager->getRepository(Block::class)->find($block->getId());
        $document = $this->entityManager->getRepository(Document::class)->find($document->getId());
        $documentDatas = $this->entityManager->getRepository(DocumentBlockData::class)->findBy(array('document'=>$document));

        $fieldArray = array();
        if($documentDatas)
        {
            $fieldArray = array();
            foreach($documentDatas as $documentData) {
                $builder->add($documentData->getId(), DocumentBlockDataType::class, array('data' => $documentData));
                $fieldArray[] = $documentData->getBlockField()->getId();
            }
        }

        foreach ($block->getFields() as $field) {
            $k = 0;
            if(!in_array($field->getID(),$fieldArray)) {
                $doc = new DocumentBlockData();
                $doc->setBlock($block);
                $doc->setBlockField($field);
                $doc->setBlockFieldType($field->getBlockFieldType());
                $doc->setDocument($document);
                $builder->add($field->getLabel()."ZAFER".$k, DocumentBlockDataType::class, array('data' => $doc));
                $k++;
            }

        }



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => null,
            'block' => null,
            'document' => null,
        ]);
    }
}
