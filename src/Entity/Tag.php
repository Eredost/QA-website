<?php

namespace App\Entity;

use App\Entity\Traits\TimestampeableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    use TimestampeableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(
     *     message = "Le nom ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 20,
     *     minMessage = "Le nom doit contenir au minimum {{ limit }} caractères",
     *     maxMessage = "Le nom doit contenir au maximum {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", mappedBy="tags")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $bgColor;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $textColor;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->bgColor   = '#42A5F5';
        $this->textColor = '#FFFFFF';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->addTag($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            $question->removeTag($this);
        }

        return $this;
    }

    public function getBgColor(): ?string
    {
        return $this->bgColor;
    }

    public function setBgColor(string $bgColor): self
    {
        $this->bgColor = $bgColor;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): self
    {
        $this->textColor = $textColor;

        return $this;
    }
}
