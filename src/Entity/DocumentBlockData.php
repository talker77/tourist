<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 * @ORM\Entity
 * @ORM\Table(name="p_document_blok_data")
 */
class DocumentBlockData
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlockField")
     */
    private $blockField;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BlockFieldType")
     */
    private $blockFieldType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Block")
     */
    private $block;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document")
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $oldContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBlockField(): ?BlockField
    {
        return $this->blockField;
    }

    public function setBlockField(?BlockField $blockField): self
    {
        $this->blockField = $blockField;

        return $this;
    }

    public function getBlock(): ?Block
    {
        return $this->block;
    }

    public function setBlock(?Block $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getBlockFieldType(): ?BlockFieldType
    {
        return $this->blockFieldType;
    }

    public function setBlockFieldType(?BlockFieldType $blockFieldType): self
    {
        $this->blockFieldType = $blockFieldType;

        return $this;
    }

    public function getOldContent(): ?string
    {
        return $this->oldContent;
    }

    public function setOldContent(?string $oldContent): self
    {
        $this->oldContent = $oldContent;

        return $this;
    }

}



