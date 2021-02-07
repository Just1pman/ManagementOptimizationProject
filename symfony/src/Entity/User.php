<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=PersonalData::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $personalData;

    /**
     * @ORM\OneToMany (targetEntity=SpokenLanguage::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $spokenLanguage;

    /**
     * @ORM\OneToMany(targetEntity=Education::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $education;

    /**
     * @ORM\OneToMany(targetEntity=CareerSummary::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $careerSummaries;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=TechnicalExperience::class, mappedBy="user")
     */
    private $technicalExperiences;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function __construct()
    {
        $this->education = new ArrayCollection();
        $this->careerSummaries = new ArrayCollection();
        $this->spokenLanguage = new ArrayCollection();
        $this->technicalExperiences = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPersonalData(): ?PersonalData
    {
        return $this->personalData;
    }

    public function setPersonalData(?PersonalData $personalData): self
    {
        // unset the owning side of the relation if necessary
        if ($personalData === null && $this->personalData !== null) {
            $this->personalData->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($personalData !== null && $personalData->getUser() !== $this) {
            $personalData->setUser($this);
        }

        $this->personalData = $personalData;

        return $this;
    }

    /**
     * @return Collection|SpokenLanguage[]
     */
    public function getSpokenLanguage(): Collection
    {
        return $this->spokenLanguage;
    }

    /**
     * @return Collection|Education[]
     */
    public function getEducation(): Collection
    {
        return $this->education;
    }

    public function addEducation(Education $education): self
    {
        if (!$this->education->contains($education)) {
            $this->education[] = $education;
            $education->setUser($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): self
    {
        if ($this->education->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getUser() === $this) {
                $education->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CareerSummary[]
     */
    public function getCareerSummaries(): Collection
    {
        return $this->careerSummaries;
    }

    public function addCareerSummary(CareerSummary $careerSummary): self
    {
        if (!$this->careerSummaries->contains($careerSummary)) {
            $this->careerSummaries[] = $careerSummary;
            $careerSummary->setUser($this);
        }

        return $this;
    }

    public function removeCareerSummary(CareerSummary $careerSummary): self
    {
        if ($this->careerSummaries->removeElement($careerSummary)) {
            // set the owning side to null (unless already changed)
            if ($careerSummary->getUser() === $this) {
                $careerSummary->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function addSpokenLanguage(SpokenLanguage $spokenLanguage): self
    {
        if (!$this->spokenLanguage->contains($spokenLanguage)) {
            $this->spokenLanguage[] = $spokenLanguage;
            $spokenLanguage->setUser($this);
        }

        return $this;
    }

    public function removeSpokenLanguage(SpokenLanguage $spokenLanguage): self
    {
        if ($this->spokenLanguage->removeElement($spokenLanguage)) {
            // set the owning side to null (unless already changed)
            if ($spokenLanguage->getUser() === $this) {
                $spokenLanguage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TechnicalExperience[]
     */
    public function getTechnicalExperiences(): Collection
    {
        return $this->technicalExperiences;
    }

    public function addTechnicalExperience(TechnicalExperience $technicalExperience): self
    {
        if (!$this->technicalExperiences->contains($technicalExperience)) {
            $this->technicalExperiences[] = $technicalExperience;
            $technicalExperience->setUser($this);
        }

        return $this;
    }

    public function removeTechnicalExperience(TechnicalExperience $technicalExperience): self
    {
        if ($this->technicalExperiences->removeElement($technicalExperience)) {
            // set the owning side to null (unless already changed)
            if ($technicalExperience->getUser() === $this) {
                $technicalExperience->setUser(null);
            }
        }

        return $this;
    }
}