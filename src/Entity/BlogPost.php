<?php

namespace App\Entity;

use App\Utility\StringUtility;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table(name="p_blog_post")
 * @ORM\Entity()
 */
class BlogPost implements Translatable
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Blog", inversedBy="posts")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    private $blog;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta_title", type="string", length=255,nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta_description", type="string", length=255,nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="meta_keywords", type="string", length=255,nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;


    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="body", type="text",nullable=true)
     */
    private $body;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="short_description", type="text",nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var string
     * @ORM\Column(name="feature_image", type="string",length=255, nullable=true)
     */
    private $featureImage;

    /**
     * @var string
     * @ORM\Column(name="header_image", type="string",length=255, nullable=true)
     */
    private $headerImage;


    /**
     * @var string
     *
     * @ORM\Column(name="page_template", type="string", length=255)
     */
    private $pageTemplate;


    /**
     * @var string
     * @ORM\Column(name="tag", type="text", nullable=true)
     */
    private $tag;

    /**
     * @var string
     * @ORM\Column(name="tag_secondary", type="text", nullable=true)
     */
    private $tagSecondary;


    /**
     * @var \DateTime
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;


    /**
     * @var \DateTime
     * @ORM\Column(name="favorite_at", type="datetime", nullable=true)
     */
    private $favoriteAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     * and it is not necessary because globally locale can be set in listener
     */
    private $locale;

    /**
     * @var \DateTime
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;


    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        if(!$this->getSlug())
        {
            $this->slug = StringUtility::smartUrl($this->getTitle());
        }

        if(!$this->getMetaTitle())
        {
            $this->setMetaTitle($this->getTitle());
        }

        if($this->getMetaDescription())
        {
            $this->setMetaDescription($this->getMetaDescription()) ;

        }

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

    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    public function setMetaKeywords(?string $metaKeywords): self
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

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

    public function getFeatureImage(): ?string
    {
        return $this->featureImage;
    }

    public function setFeatureImage(?string $featureImage): self
    {
        $this->featureImage = $featureImage;

        return $this;
    }

    public function getHeaderImage(): ?string
    {
        return $this->headerImage;
    }

    public function setHeaderImage(?string $headerImage): self
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    public function getPageTemplate(): ?string
    {
        return $this->pageTemplate;
    }

    public function setPageTemplate(string $pageTemplate): self
    {
        $this->pageTemplate = $pageTemplate;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

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

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getFavoriteAt(): ?\DateTimeInterface
    {
        return $this->favoriteAt;
    }

    public function setFavoriteAt(?\DateTimeInterface $favoriteAt): self
    {
        $this->favoriteAt = $favoriteAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTagSecondary(): ?string
    {
        return $this->tagSecondary;
    }

    public function setTagSecondary(?string $tagSecondary): self
    {
        $this->tagSecondary = $tagSecondary;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    public function getisActive(): ?bool
    {
        return $this->isActive;
    }

    public function setisActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }





}
