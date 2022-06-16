<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="itp_user")
 */
class User extends BaseUser
{

    CONST ORDER_USER = "order_creation";


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;





    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string",nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="orderCount", type="string",nullable=true)
     */
    private $orderCount;


    /**
     * @var integer
     *
     * @ORM\Column(name="phone", type="string",nullable=true)
     */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="location", type="string",nullable=true)
     */
    private $location;


    /**
     * @var integer
     *
     * @ORM\Column(name="notes", type="text",nullable=true)
     */
    private $notes;


    /**
     * @var integer
     *
     * @ORM\Column(name="last_order_date", type="datetime",nullable=true)
     */
    private $lastOrderDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_order_id", type="string",nullable=true)
     */
    private $lastOrderId;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_amount", type="string",nullable=true)
     */
    private $totalAmount;

    /**
     * @var string
     * @ORM\Column(name="client_ip", type="string", length=200, nullable=true)
     */
    private $clientIp;

    /**
     * @var string
     * @ORM\Column(name="browser_agent", type="string", length=200, nullable=true)
     */
    private $browserAgent;


    /**
     * @var string
     * @ORM\Column(name="user_source", type="string", length=200, nullable=true)
     */
    private $source;

    /**
     * @var string
     * @ORM\Column(name="payment_token", type="string", length=200, nullable=true)
     */
    private $paymentToken;

    /**
     * @var string
     * @ORM\Column(name="login_hash", type="string", length=200, nullable=true)
     */
    private $loginHash;


    /**
     * @var string
     * @ORM\Column(name="has_password", type="boolean", nullable=true)
     */
    private $hasPassword;


    /**
     * @var string
     * @ORM\Column(name="tags", type="json", nullable=true)
     */
    private $tags;

    /**
     * @var boolean
     * @ORM\Column(name="limitedAccess", type="boolean", nullable=true)
     */
    private $limitedAccess;







    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;


    public function getSubscriberHash()
    {
        return md5(strtolower($this->getEmail()));
    }

    public function __construct()
    {
        parent::__construct();
        $this->services = new ArrayCollection();
    }




    /**
     * Overridden so that username is now optional
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->setUsername($email);
        return parent::setEmail($email);
    }

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

    public function getOrderCount(): ?string
    {
        return $this->orderCount;
    }

    public function setOrderCount(?string $orderCount): self
    {
        $this->orderCount = $orderCount;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getLastOrderDate(): ?\DateTimeInterface
    {
        return $this->lastOrderDate;
    }

    public function setLastOrderDate(?\DateTimeInterface $lastOrderDate): self
    {
        $this->lastOrderDate = $lastOrderDate;

        return $this;
    }

    public function getLastOrderId(): ?string
    {
        return $this->lastOrderId;
    }

    public function setLastOrderId(?string $lastOrderId): self
    {
        $this->lastOrderId = $lastOrderId;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(?string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getClientIp(): ?string
    {
        return $this->clientIp;
    }

    public function setClientIp(?string $clientIp): self
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    public function getBrowserAgent(): ?string
    {
        return $this->browserAgent;
    }

    public function setBrowserAgent(?string $browserAgent): self
    {
        $this->browserAgent = $browserAgent;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getPaymentToken(): ?string
    {
        return $this->paymentToken;
    }

    public function setPaymentToken(?string $paymentToken): self
    {
        $this->paymentToken = $paymentToken;

        return $this;
    }

    public function getLoginHash(): ?string
    {
        return $this->loginHash;
    }

    public function setLoginHash(?string $loginHash): self
    {
        $this->loginHash = $loginHash;

        return $this;
    }

    public function getHasPassword(): ?bool
    {
        return $this->hasPassword;
    }

    public function setHasPassword(?bool $hasPassword): self
    {
        $this->hasPassword = $hasPassword;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getLimitedAccess(): ?bool
    {
        return $this->limitedAccess;
    }

    public function setLimitedAccess(?bool $limitedAccess): self
    {
        $this->limitedAccess = $limitedAccess;

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
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }


}
