<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryQuestionsRepository")
 */
class CategoryQuestions
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
    private $reasonquestion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="reason")
     */
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReasonquestion(): ?string
    {
        return $this->reasonquestion;
    }

    public function setReasonquestion(string $reasonquestion): self
    {
        $this->reasonquestion = $reasonquestion;

        return $this;
    }


    public function __toString()
    {
        return $this->reasonquestion; 
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setReason($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getReason() === $this) {
                $contact->setReason(null);
            }
        }

        return $this;
    }
}
