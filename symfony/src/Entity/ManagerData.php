<?php

namespace App\Entity;

use App\Repository\ManagerDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagerDataRepository::class)
 */
class ManagerData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userRole;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userSalary;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="managerData", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserRole(): ?string
    {
        return $this->userRole;
    }

    public function setUserRole(?string $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    public function getUserSalary(): ?string
    {
        return $this->userSalary;
    }

    public function setUserSalary(?string $userSalary): self
    {
        $this->userSalary = $userSalary;

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
