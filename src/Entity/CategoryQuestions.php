<?php

namespace App\Entity;

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
     * @ORM\JoinColumn(nullable=false)
     */
    private $contact;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function __toString()
    {
        return $this->reasonquestion; 
    }
}
