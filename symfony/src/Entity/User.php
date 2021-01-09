<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @ORM\ManyToOne(targetEntity=SpokenLanguage::class, inversedBy="user")
     */
    private $spokenLanguage;

    /**
     * @ORM\OneToMany(targetEntity=Education::class, mappedBy="user")
     */
    private $education;

    /**
     * @ORM\OneToMany(targetEntity=CareerSummary::class, mappedBy="user")
     */
    private $careerSummaries;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->education = new ArrayCollection();
        $this->dateStart = new ArrayCollection();
        $this->careerSummaries = new ArrayCollection();
    }

    public function __toString():string
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

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
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

    public function getSpokenLanguage(): ?SpokenLanguage
    {
        return $this->spokenLanguage;
    }

    public function setSpokenLanguage(?SpokenLanguage $spokenLanguage): self
    {
        $this->spokenLanguage = $spokenLanguage;

        return $this;
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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
