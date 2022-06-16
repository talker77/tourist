<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttractionRepository")
 * @ORM\Table(name="p_attraction")
 */
class Attraction implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;


    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="video_cover", type="string", length=255, nullable=true)
     */
    private $videoCover;

    /**
     * @var string
     * @ORM\Column(name="video_url", type="text", nullable=true)
     */
    private $videoUrl;

    /**
     * @var string
     * @ORM\Column(name="dip_note", type="text", nullable=true)
     */
    private $dipNote;

    /**
     * @var string
     * @ORM\Column(name="banner_text", type="text", nullable=true)
     */
    private $bannerText;

    /**
     * @var string
     * @ORM\Column(name="advantages_text", type="text", nullable=true)
     */
    private $AdvantagesText;

    /**
     * @var string
     * @ORM\Column(name="about_tour", type="text", nullable=true)
     */
    private $aboutTour;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="admission", type="text", nullable=true)
     */
    private $admission;

    /**
     * @var string
     * @ORM\Column(name="hours", type="text", nullable=true)
     */
    private $hours;

    /**
     * @var string
     * @ORM\Column(name="gettingthere", type="text", nullable=true)
     */
    private $gettingThere;

    /**
     * @var string
     * @ORM\Column(name="remark", type="text", nullable=true)
     */
    private $remark;

    /**
     * @var string
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    private $thumbnail;

    /**
     * @ORM\OneToMany(targetEntity="AttractionImage", mappedBy="attraction")
     */
    private $images;

    /**
     * @var string
     * @ORM\Column(name="badge", type="string", length=255, nullable=true)
     */
    private $badge;

    /**
     * @var float
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var float
     * @ORM\Column(name="pass_price", type="float", nullable=true)
     */
    private $passPrice;

    /**
     * @var string
     * @ORM\Column(name="google_map", type="text", nullable=true)
     */
    private $googleMap;

    /**
     * @var string
     * @ORM\Column(name="embed_map", type="text", nullable=true)
     */
    private $embedMap;

    /**
     * @var float
     * @ORM\Column(name="rating", type="float", nullable=true)
     */
    private $rating;

    /**
     * @var int
     * @ORM\Column(name="review", type="integer", nullable=true)
     */
    private $review;

    /**
     * @var int
     * @ORM\Column(name="ranking", type="smallint", nullable=true)
     */
    private $ranking;

    /**
     * @var int
     * @ORM\Column(name="days", type="smallint", nullable=true)
     */
    private $days;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dont_show_on_screen", type="boolean", nullable=true)
     */
    private $dontShowOnScreen;

    /**
     * @var integer
     *
     * @ORM\Column(name="show_on_home", type="integer", nullable=true)
     */
    private $showOnHome;

    /**
     * @var boolean
     *
     * @ORM\Column(name="blog", type="boolean", nullable=true)
     */
    private $blog;

    /**
     * @var string
     *
     * @ORM\Column(name="book_now", type="text", nullable=true)
     */
    private $bookNow;


    /**
     * @var integer
     *
     * @ORM\Column(name="order_index", type="integer", nullable=true)
     */
    private $sortingIndex;


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
     * @var \DateTime
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $lng;

    /**
     * @var string
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;


    /**
     * @var string
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $learnMore;


    public function jsonSerialize()
    {

        $images = $this->getImages();
        $imageItems= array();
        foreach($images as $image)
        {
            $imageItems = array('id'=>$image->getId(),'src'=>$image->getSrc(),'position'=>$image->getPosition());
        }

        return array(
                'id' => $this->getId() ,
                'name' => $this->getTitle() ,
                'shortDescription' => $this->getAdmission(),
                'description' =>  strip_tags($this->getDescription()),
                'gettingThere' => $this->getGettingThere(),
                'hours' => $this->getHours(),
                'admission' => $this->getAdmission(),
                'video_url' => $this->getVideoUrl(),
                'dipNote' => $this->getDipNote(),
                'bannerText'=> $this->bannerText(),
                'learnMore' => $this->getLearnMore(),
                'aboutTour' => $this->getAboutTour(),
                'remark' => $this->getRemark(),
                'map' => $this->getGoogleMap(),
                'imagePath' => "https://istanbultouristpass.com/".$this->getThumbnail(),
                'label' => ($this->getCategory()) ? ($this->getCategory()->getTitle()) : null,
                'lat' => $this->getLat(),
                'lng' => $this->getLng(),
                'rating' =>$this->getRating(),
                'review' =>$this->getReview(),
                'ranking' =>$this->getRanking(),
                'price' => $this->getPrice(),
                'images' => $imageItems,
                'slug' =>  $this->getSlug(),
                'baseUrl' => 'https://istanbultouristpass.com/'
        );
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
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

    public function getAdvantagesText(): ?string
    {
        return $this->AdvantagesText;
    }

    public function setAdvantagesText(?string $AdvantagesText): self
    {
        $this->AdvantagesText = $AdvantagesText;

        return $this;
    }

    public function getDipNote(): ?string
    {
        return $this->dipNote;
    }

    public function setDipNote(?string $dipNote): self
    {
        $this->dipNote = $dipNote;

        return $this;
    }

    public function getVideoCover(): ?string
    {
        return $this->videoCover;
    }

    public function setVideoCover(?string $videoCover): self
    {
        $this->videoCover = $videoCover;
        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;
        return $this;
    }

    public function getBannerText(): ?string
    {
        return $this->bannerText;
    }

    public function setBannerText(?string $aboutTour): self
    {
        $this->bannerText = $aboutTour;

        return $this;
    }

    public function getAboutTour(): ?string
    {
        return $this->aboutTour;
    }

    public function setAboutTour(?string $aboutTour): self
    {
        $this->aboutTour = $aboutTour;

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

    public function getAdmission(): ?string
    {
        return $this->admission;
    }

    public function setAdmission(?string $admission): self
    {
        $this->admission = $admission;

        return $this;
    }

    public function getHours(): ?string
    {
        return $this->hours;
    }

    public function setHours(?string $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getGettingThere(): ?string
    {
        return $this->gettingThere;
    }

    public function setGettingThere(?string $gettingThere): self
    {
        $this->gettingThere = $gettingThere;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getBadge(): ?string
    {
        return $this->badge;
    }

    public function setBadge(?string $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPassPrice(): ?float
    {
        return $this->passPrice;
    }

    public function setPassPrice(?float $passPrice): self
    {
        $this->passPrice = $passPrice;

        return $this;
    }

    public function getGoogleMap(): ?string
    {
        return $this->googleMap;
    }

    public function setGoogleMap(?string $googleMap): self
    {
        $this->googleMap = $googleMap;

        return $this;
    }

    public function getEmbedMap(): ?string
    {
        return $this->embedMap;
    }

    public function setEmbedMap(?string $embedMap): self
    {
        $this->embedMap = $embedMap;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReview(): ?int
    {
        return $this->review;
    }

    public function setReview(?int $review): self
    {
        $this->review = $review;

        return $this;
    }

    public function getRanking(): ?int
    {
        return $this->ranking;
    }

    public function setRanking(?int $ranking): self
    {
        $this->ranking = $ranking;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(?int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getDontShowOnScreen(): ?bool
    {
        return $this->dontShowOnScreen;
    }

    public function setDontShowOnScreen(?bool $dontShowOnScreen): self
    {
        $this->dontShowOnScreen = $dontShowOnScreen;

        return $this;
    }

    /**
     * @return int
     */
    public function getShowOnHome(): ?int
    {
        return $this->showOnHome;
    }

    /**
     * @param int $showOnHome
     */
    public function setShowOnHome(int $showOnHome): void
    {
        $this->showOnHome = $showOnHome;
    }


    public function getBlog(): ?bool
    {
        return $this->blog;
    }

    public function setBlog(?bool $blog): self
    {
        $this->blog = $blog;

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

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getBookNow()
    {
        return $this->bookNow;
    }

    /**
     * @param string $bookNow
     */
    public function setBookNow(string $bookNow): void
    {
        $this->bookNow = $bookNow;
    }

    /**
     * @return Collection|AttractionImage[]
     */
    public function getImages(): Collection
    {
        return $this->images->filter(function(AttractionImage $image) {
            return $image->getDeletedAt() == null;
        });
    }

    public function addImage(AttractionImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAttraction($this);
        }

        return $this;
    }

    public function removeImage(AttractionImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getAttraction() === $this) {
                $image->setAttraction(null);
            }
        }

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle(string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription(string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    public function getLearnMore(): ?string
    {
        return $this->learnMore;
    }

    public function setLearnMore(?string $learnMore): self
    {
        $this->learnMore = $learnMore;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     */
    public function setUpdateAt(\DateTime $updateAt): void
    {
        $this->updateAt = $updateAt;
    }

    /**
     * @return int
     */
    public function getSortingIndex(): ?int
    {
        return $this->sortingIndex;
    }

    /**
     * @param int $sortingIndex
     */
    public function setSortingIndex(int $sortingIndex): void
    {
        $this->sortingIndex = $sortingIndex;
    }





}
