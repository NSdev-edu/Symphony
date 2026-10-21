<?php

namespace App\Entity;

use App\Repository\ExerciseTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciseTypeRepository::class)]
class ExerciseType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
	#[Assert\NotBlank(message: 'Podaj nazwe.')]
	#[Assert\Length(max: 100, maxMessage: 'Nazwa moze miec najwyzej {{ limit }} znakow.')]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
