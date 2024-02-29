<?php

namespace App\Entity;

use App\Repository\AchievementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
class Achievement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Achievement = null;

    #[ORM\Column(length: 255)]
    private ?string $AchievementImage = null;

    #[ORM\Column(length: 255)]
    private ?string $DateAchieved = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAchievement(): ?string
    {
        return $this->Achievement;
    }

    public function setAchievement(string $Achievement): static
    {
        $this->Achievement = $Achievement;

        return $this;
    }

    public function getAchievementImage(): ?string
    {
        return $this->AchievementImage;
    }

    public function setAchievementImage(string $AchievementImage): static
    {
        $this->AchievementImage = $AchievementImage;

        return $this;
    }

    public function getDateAchieved(): ?string
    {
        return $this->DateAchieved;
    }

    public function setDateAchieved(string $DateAchieved): static
    {
        $this->DateAchieved = $DateAchieved;

        return $this;
    }
}
