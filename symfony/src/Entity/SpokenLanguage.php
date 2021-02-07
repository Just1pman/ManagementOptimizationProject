<?php

namespace App\Entity;

use App\Repository\SpokenLanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpokenLanguageRepository::class)
 */
class SpokenLanguage
{
    const LANGUAGE = [
        "English" => "English",
        "Russian" => "Russian",
        "Polish" => "Polish",
        "Deutsch" => "Deutsch",
        "Chinese" => "Chinese",
        "Ukrainian" => "Ukrainian"
    ];

    const LEVEL = [
        "Beginner" => "Beginner",
        "Elementary" => "Elementary",
        "Intermediate" => "Intermediate",
        "Upper-Intermediate" => "Upper-Intermediate",
        "Advanced" => "Advanced",
        "Proficiency" => "Proficiency",
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne (targetEntity=User::class, inversedBy="spokenLanguage")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setSpokenLanguage($this);
        }

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
