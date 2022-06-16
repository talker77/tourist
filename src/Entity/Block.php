<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 * @ORM\Entity
 * @ORM\Table(name="p_block")
 */
class Block
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
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $placeHolder;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlockField", mappedBy="block")
     */
    private $fields;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    public function __toString()
    {
     return $this->title;
    }

    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPlaceHolder(): ?string
    {
        return $this->placeHolder;
    }

    public function setPlaceHolder(?string $placeHolder): self
    {
        $this->placeHolder = $placeHolder;

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

    /**
     * @return Collection|BlockField[]
     */
    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(BlockField $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
            $field->setBlock($this);
        }

        return $this;
    }

    public function removeField(BlockField $field): self
    {
        if ($this->fields->removeElement($field)) {
            // set the owning side to null (unless already changed)
            if ($field->getBlock() === $this) {
                $field->setBlock(null);
            }
        }

        return $this;
    }

}



