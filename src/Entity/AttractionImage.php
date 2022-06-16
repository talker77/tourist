<?php

namespace App\Entity;

use App\Utility\StringUtility;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttractionImageRepository")
 * @ORM\Table(name="p_attraction_image")
 */
class AttractionImage implements \JsonSerializable
{
    const SERVER_PATH_TO_IMAGE_FOLDER = 'app/img/inclusions';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Attraction", inversedBy="images")
     * @ORM\JoinColumn(name="attraction_id")
     */
    private $attraction;

    /**
     * @var int
     * @ORM\Column(name="position", length=2)
     */
    private $position;

    /**
     * @var string
     * @ORM\Column(name="src", type="string", length=255, nullable=true)
     */
    private $src;

    /**
     * @var string
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

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
     * Unmapped property to handle file uploads
     */
    private $file;


    public function jsonSerialize()
    {
        return array(
            'id' =>$this->getId(),
            'src' =>$this->getSrc(),
            'alt' =>$this->getAlt(),
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAttraction()
    {
        return $this->attraction;
    }

    /**
     * @param mixed $attraction
     */
    public function setAttraction($attraction): void
    {
        $this->attraction = $attraction;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @param string $src
     */
    public function setSrc(string $src): void
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
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

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }


    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $newFileName = StringUtility::urlSlugify($this->getAttraction()->getTitle().' '.$this->getPosition()).'.'.$this->getFile()->getClientOriginalExtension();

        $this->getFile()->move(
            self::SERVER_PATH_TO_IMAGE_FOLDER,
            $newFileName
        );

        $this->setSrc(self::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$newFileName);

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }
}
