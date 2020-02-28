<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $optionGift;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DeliveryOptions", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryOption;

    /**
     * @ORM\Column(type="float")
     */
    private $orderPriceTotal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $deliveryAddress;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facturationAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOptionGift(): ?bool
    {
        return $this->optionGift;
    }

    public function setOptionGift(bool $optionGift): self
    {
        $this->optionGift = $optionGift;

        return $this;
    }

    public function getDeliveryOption(): ?DeliveryOptions
    {
        return $this->deliveryOption;
    }

    public function setDeliveryOption(?DeliveryOptions $deliveryOption): self
    {
        $this->deliveryOption = $deliveryOption;

        return $this;
    }

    public function getOrderPriceTotal(): ?float
    {
        return $this->orderPriceTotal;
    }

    public function setOrderPriceTotal(float $orderPriceTotal): self
    {
        $this->orderPriceTotal = $orderPriceTotal;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDeliveryAddress(): ?Adress
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Adress $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getFacturationAddress(): ?Adress
    {
        return $this->facturationAddress;
    }

    public function setFacturationAddress(?Adress $facturationAddress): self
    {
        $this->facturationAddress = $facturationAddress;

        return $this;
    }
}
