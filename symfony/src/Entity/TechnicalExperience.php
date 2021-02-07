<?php

namespace App\Entity;

use App\Repository\TechnicalExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TechnicalExperienceRepository::class)
 */
class TechnicalExperience
{
    const LEVEL = [
        "Basic" => "Basic",
        "Intermediate" => "Intermediate",
        "Advanced" => "Advanced",
        "Expert" => "Expert",

    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Category::class, cascade={"persist", "remove"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="technicalExperience")
     */
    private $skill;

    /**
     * @ORM\Column(type="integer")
     */
    private $experienceTerm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $lastYearUsed;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="technicalExperiences")
     */
    private $user;

    public function __construct()
    {
        $this->skill = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkill(): Collection
    {
        return $this->skill;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skill->contains($skill)) {
            $this->skill[] = $skill;
            $skill->setTechnicalExperience($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skill->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getTechnicalExperience() === $this) {
                $skill->setTechnicalExperience(null);
            }
        }

        return $this;
    }

    public function getExperienceTerm(): ?int
    {
        return $this->experienceTerm;
    }

    public function setExperienceTerm(int $experienceTerm): self
    {
        $this->experienceTerm = $experienceTerm;

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

    public function getLastYearUsed(): ?int
    {
        return $this->lastYearUsed;
    }

    public function setLastYearUsed(int $lastYearUsed): self
    {
        $this->lastYearUsed = $lastYearUsed;

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
}
