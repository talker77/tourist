<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="p_category")
 */
class Category implements \JsonSerializable
{
    /*
    const ATTRACTION_CATEGORY_MUSSEUM = 1;
    const ATTRACTION_CATEGORY_ATTRACTION = 2;
    const ATTRACTION_CATEGORY_SERVICES = 3;
    const ATTRACTION_CATEGORY_SUPPORT = 4;
    const ATTRACTION_CATEGORY_BLOG = 5;
*/
    const ATTRACTION_CATEGORY_MUSEUM_TOUR   = 1;
    const ATTRACTION_CATEGORY_ISTANBUL = 2;
    const ATTRACTION_CATEGORY_MUSEUM = 3;
    const ATTRACTION_CATEGORY_DAY = 4;
    const ATTRACTION_CATEGORY_TICKETS = 5;
    const ATTRACTION_CATEGORY_ACTIVITIES = 6;
    const ATTRACTION_CATEGORY_DISCOUNT = 7;
    const ATTRACTION_CATEGORY_TRANSFERS = 8;
    const ATTRACTION_CATEGORY_BLOG = 9;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAttraction;

    public function __toString()
    {
      return $this->getTitle();
    }


    public function jsonSerialize()
    {
        return array(
            'id'=> $this->getId(),
            'title'=> $this->getTitle(),
            'imagePath' =>$this->getImage()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function getIsAttraction(): ?bool
    {
        return $this->isAttraction;
    }

    public function setIsAttraction(?bool $isAttraction): self
    {
        $this->isAttraction = $isAttraction;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


}
