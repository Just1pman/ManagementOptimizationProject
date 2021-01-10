<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $internalTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externalTitle;

    /**
     * @ORM\Column(type="date")
     */
    private $periodStart;

    /**
     * @ORM\Column(type="date")
     */
    private $periodEnd;

    /**
     * @ORM\ManyToOne(targetEntity=ProjectRole::class, inversedBy="projects")
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="projects")
     */
    private $technologies;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInternalTitle(): ?string
    {
        return $this->internalTitle;
    }

    public function setInternalTitle(string $internalTitle): self
    {
        $this->internalTitle = $internalTitle;

        return $this;
    }

    public function getExternalTitle(): ?string
    {
        return $this->externalTitle;
    }

    public function setExternalTitle(string $externalTitle): self
    {
        $this->externalTitle = $externalTitle;

        return $this;
    }

    public function getPeriodStart(): ?\DateTimeInterface
    {
        return $this->periodStart;
    }

    public function setPeriodStart(\DateTimeInterface $periodStart): self
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    public function getPeriodEnd(): ?\DateTimeInterface
    {
        return $this->periodEnd;
    }

    public function setPeriodEnd(\DateTimeInterface $periodEnd): self
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    public function getRole(): ?ProjectRole
    {
        return $this->role;
    }

    public function setRole(?ProjectRole $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Skill $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Skill $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
