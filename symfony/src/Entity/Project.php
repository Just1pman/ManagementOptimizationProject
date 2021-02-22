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
     * @ORM\ManyToMany(targetEntity=Technology::class, cascade="persist")
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

    public function setPeriodStart(\DateTimeInterface$periodStart): self
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

    /**
     * @return Collection|Skill[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }
// если технология содержится в базе, тогда не добавляем её в базу, а просто добавляем её id
    public function addTechnology($technology): self
    {
//        $technologyRepository = $this->em->getRepository(Technology::class);
//
//
        if (!$this->technologies->contains($technology) ) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology($technology): self
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
