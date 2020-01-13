<?php

namespace App\Entity;

use App\Entity\Traits\TimestampeableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
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
     *     message = "La saisie du nom est obligatoire"
     * )
     * @Assert\Length(
     *     min = 5,
     *     max = 20,
     *     minMessage = "Le nom doit contenir au minimum {{ limit }} caractères",
     *     maxMessage = "Le nom doit contenir au maximum {{ limit }} caractères"
     * )
     */
    private $name;

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
}
