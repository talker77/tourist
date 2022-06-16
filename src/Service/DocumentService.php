<?php


namespace App\Service;


use App\Entity\Document;
use App\Entity\DocumentBlockData;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;

class DocumentService
{

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(EntityManagerInterface $em,DocumentRepository $documentRepository)
    {
        $this->em = $em;
        $this->documentRepository = $documentRepository;
    }

    public function getDocumentBySlug($slug): ?Document
    {
        $document = $this->documentRepository->findOneBySlug($slug);
        if($document->getBlocks()) {
            $dataArray = array();
            foreach ($document->getBlocks() as $block) {
                $dataArray[$block->getPlaceHolder()] = $this->em->getRepository(DocumentBlockData::class)->findBy(array('document' => $document, 'block' => $block));;
            }
            $document->blockData = $dataArray;
        }


        return $document;
    }
}