<?php

namespace App\Entity;

use App\Utility\StringUtility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Page
 *
 * @ORM\Table(name="p_blog")
 * @ORM\Entity()
 */
class Blog
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
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost",mappedBy="blog")
     * @ORM\OrderBy({"publishedAt" = "desc"})
     */
    private $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="page_template", type="string", length=255)
     */
    private $pageTemplate;

    /**
     * @var string
     * @ORM\Column(name="feature_image", type="string",length=255, nullable=true)
     */
    private $featureImage;

    /**
     * @var string
     * @Assert\NotBlank()

     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string

     * @ORM\Column(name="short_description", type="text",nullable=true)
     */
    private $shortDescription;

    /**
     * @var string

     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string

     * @ORM\Column(name="meta_title", type="string", length=255,nullable=true)
     */
    private $metaTitle;

    /**
     * @var string

     * @ORM\Column(name="meta_description", type="string", length=255,nullable=true)
     */
    private $metaDescription;

    /**
     * @var string

     * @ORM\Column(name="meta_keywords", type="string", length=255,nullable=true)
     */
    private $metaKeywords;



    /**
     * @var \DateTime
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

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
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="lang", type="string", length=255)
     */
    private $lang;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    public function getTags()
    {
        $tags = array();
        if($this->getPosts())
        {
            foreach($this->getPosts() as $post){
                    $tags[]=$post->getTag();

            }
        }

        return array_unique($tags);
    }


    /**
     * @return Array|BlogPost[]
     */
    public function getFavoritePosts(): Array
    {
        $favorites = array();
        if($this->getPosts())
        {
            foreach($this->getPosts() as $post){
                if($post->getFavoriteAt())
                {
                    $favorites[]=$post;
                }
            }
        }


        return $favorites;
    }

    /**
     * @return Array|BlogPost[]
     */
    public function getPostsArray(): Array
    {
        $favorites = array();
        if($this->getPosts())
        {
            foreach($this->getPosts() as $post){
                $favorites[]=$post;
            }
        }


        return $favorites;
    }


    public function __toString()
    {
        return $this->getTitle();
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
            $this->slug = StringUtility::slugify($this->getTitle());
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }



    public function addPost(BlogPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setBlog($this);
        }

        return $this;
    }

    public function removePost(BlogPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getBlog() === $this) {
                $post->setBlog(null);
            }
        }

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

    public function getFeatureImage(): ?string
    {
        return $this->featureImage;
    }

    public function setFeatureImage(?string $featureImage): self
    {
        $this->featureImage = $featureImage;

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


    public function getLang(): ?string
    {
        if(isset($GLOBALS['request']) && $GLOBALS['request']) {
            $locale = $GLOBALS['request']->getLocale();
        } else {
            $locale = 'tr';
        }
        $this->lang = $locale;
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }






}
