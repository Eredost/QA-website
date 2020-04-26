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
     *     message = "The name could not be blank"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 20,
     *     minMessage = "The name should contain at least {{ limit }} characters",
     *     maxMessage = "The name should contain a maximum of {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Question", mappedBy="tags")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(
     *     message = "The background color value can't be blank"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 25,
     *     minMessage = "The background color value is too short, please specify minimum {{ limit }} characters",
     *     maxMessage = "The background color value is too long, you can use hexadecimal, rgb or color name"
     * )
     */
    private $bgColor;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(
     *     message = "The text color value can't be blank"
     * )
     * @Assert\Length(
     *     min = 3,
     *     max = 25,
     *     minMessage = "The text color value is too short, please specify minimum {{ limit }} characters",
     *     maxMessage = "The text color value is too long, you can use hexadecimal, rgb or color name"
     * )
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
