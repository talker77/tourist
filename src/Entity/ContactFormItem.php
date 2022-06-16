<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="p_contact_form_item")
 */
class ContactFormItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255 ,nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="subject", type="string", length=255 ,nullable=true)
     */
    private $subject;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255 ,nullable=true)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="message", type="text",nullable=true)
     */
    private $message;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="read_at", type="datetime", nullable=true)
     *
     */
    private $readAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
    public function getSubject(): ?string
    {
        return $this->subject;
    }
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
     * @return \DateTime
     */
    public function getReadAt(): ?\DateTime
    {
        return $this->readAt;
    }

    /**
     * @param \DateTime $readAt
     */
    public function setReadAt(\DateTime $readAt): void
    {
        $this->readAt = $readAt;
    }



}