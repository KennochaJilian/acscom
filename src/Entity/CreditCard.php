<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditCardRepository")
 */
class CreditCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberCard;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $securityCryptomgram;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameUser;

    /**
     * @ORM\Column(type="date")
     */
    private $expirationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="creditCard")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
     return $this->id;
    }

    public function getNumberCard(): ?string
    {
        return $this->numberCard;
    }

    public function setNumberCard(string $numberCard): self
    {
        $this->numberCard = $numberCard;

        return $this;
    }

    public function getSecurityCryptomgram(): ?string
    {
        return $this->securityCryptomgram;
    }

    public function setSecurityCryptomgram(string $securityCryptomgram): self
    {
        $this->securityCryptomgram = $securityCryptomgram;

        return $this;
    }

    public function getNameUser(): ?string
    {
        return $this->nameUser;
    }

    public function setNameUser(string $nameUser): self
    {
        $this->nameUser = $nameUser;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCreditCard($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCreditCard() === $this) {
                $user->setCreditCard(null);
            }
        }

        return $this;
    }
}
