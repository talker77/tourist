<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 * @ORM\Entity
 * @ORM\Table(name="p_document")
 */
class Document
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pageName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaTitle;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metaDescription;


    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $handle;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $title1;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $title2;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $title3;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $template;

    /**
     * @var \Doctrine\Common\Collections\Collection|Block[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Block")
     * @ORM\JoinTable(
     *  name="p_document_block",
     *  joinColumns={
     *      @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $blocks;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var DocumentBlockData[]
     */
    public $blockData;


    public function getBlockByFieldKey($key)
    {
        foreach($this->blockData as $blockName => $fields)
        {
            foreach($fields as $field) {
                if ($field->getBlockField()->getName() == $key) {
                    return $field->getContent();
                }
            }
        }
        return ;
    }

    public function __toString()
    {
     return $this->pageName;
    }

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageName(): ?string
    {
        return $this->pageName;
    }

    public function setPageName(?string $pageName): self
    {
        $this->pageName = $pageName;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    public function setMetaTitle(?string $metaTitle): self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getHandle(): ?string
    {
        return $this->handle;
    }

    public function setHandle(string $handle): self
    {
        $this->handle = $handle;

        return $this;
    }

    public function getTitle1(): ?string
    {
        return $this->title1;
    }

    public function setTitle1(?string $title1): self
    {
        $this->title1 = $title1;

        return $this;
    }

    public function getTitle2(): ?string
    {
        return $this->title2;
    }

    public function setTitle2(?string $title2): self
    {
        $this->title2 = $title2;

        return $this;
    }

    public function getTitle3(): ?string
    {
        return $this->title3;
    }

    public function setTitle3(?string $title3): self
    {
        $this->title3 = $title3;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Block[]
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(Block $block): self
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks[] = $block;
        }

        return $this;
    }

    public function removeBlock(Block $block): self
    {
        $this->blocks->removeElement($block);

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

}



