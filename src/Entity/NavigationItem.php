<?php

namespace App\Entity;

use App\Entity\Navigation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * SubCategories
 *
 * @ORM\Table(name="p_navigation_item")
 * @ORM\Entity(repositoryClass="App\Repository\NavigationItemRepository")
 */
class NavigationItem  implements Translatable
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Navigation")
     * @ORM\JoinColumn(name="navigation_id", referencedColumnName="id")
     */
    private $navigation;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Document")
     * @ORM\JoinColumn(name="document_id", referencedColumnName="id")
     */
    private $document;


    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="place_holder", type="string",nullable=true, length=255)
     */
    private $placeHolder;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255,nullable=true)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="target", type="string",nullable=true, length=255)
     */
    private $target;


    /**
     * @var string
     * @ORM\Column(name="extra_class", type="string",nullable=true, length=255)
     */
    private $extraClass;


    /**
     * @var string
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $rollOverTitle;

    /**
     * @var string
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $rollOverLabel;

    /**
     * @var string
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $subtitle;

    /**
     * @var string
     * @ORM\Column(type="text",nullable=true)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(type="string",nullable=true)
     */
    private $banner;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $bannerLabel;

    /**
     * @var string
     * @ORM\Column(type="string",nullable=true)
     */
    private $bannerLink;



    /**
     * @var integer
     *
     * @ORM\Column(name="pos_left", type="integer", nullable=true)
     */
    private $left;

    /**
     * @var integer
     *
     * @ORM\Column(name="pos_right", type="integer", nullable=true)
     */
    private $right;


    /**
     * @var integer
     *
     * @ORM\Column(name="top", type="integer", nullable=true)
     */
    private $top;


    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;


    /**
     * @var integer
     *
     * @ORM\Column(name="pos_order", type="integer", nullable=true)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\NavigationItem")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     */
    private $parent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var string
     * @ORM\Column(name="lang", type="string", length=255,nullable=true)
     */
    private $lang;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    private $locale;

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function __toString()
    {
      return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getExtraClass(): ?string
    {
        return $this->extraClass;
    }

    public function setExtraClass(?string $extraClass): self
    {
        $this->extraClass = $extraClass;

        return $this;
    }

    public function getLeft(): ?int
    {
        return $this->left;
    }

    public function setLeft(?int $left): self
    {
        $this->left = $left;

        return $this;
    }

    public function getRight(): ?int
    {
        return $this->right;
    }

    public function setRight(?int $right): self
    {
        $this->right = $right;

        return $this;
    }

    public function getTop(): ?int
    {
        return $this->top;
    }

    public function setTop(?int $top): self
    {
        $this->top = $top;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;

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

    public function getNavigation(): ?Navigation
    {
        return $this->navigation;
    }

    public function setNavigation(?Navigation $navigation): self
    {
        $this->navigation = $navigation;

        return $this;
    }



    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    public function getBannerLabel(): ?string
    {
        return $this->bannerLabel;
    }

    public function setBannerLabel(?string $bannerLabel): self
    {
        $this->bannerLabel = $bannerLabel;

        return $this;
    }

    public function getBannerLink(): ?string
    {
        return $this->bannerLink;
    }

    public function setBannerLink(?string $bannerLink): self
    {
        $this->bannerLink = $bannerLink;

        return $this;
    }

    public function getRollOverTitle(): ?string
    {
        return $this->rollOverTitle;
    }

    public function setRollOverTitle(?string $rollOverTitle): self
    {
        $this->rollOverTitle = $rollOverTitle;

        return $this;
    }

    public function getRollOverLabel(): ?string
    {
        return $this->rollOverLabel;
    }

    public function setRollOverLabel(?string $rollOverLabel): self
    {
        $this->rollOverLabel = $rollOverLabel;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;

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



}
