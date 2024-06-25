<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $role_name = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class)]
    private Collection $user_role;

    public function __construct()
    {
        $this->user_role = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleName(): ?string
    {
        return $this->role_name;
    }

    public function setRoleName(string $role_name): static
    {
        $this->role_name = $role_name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserRole(): Collection
    {
        return $this->user_role;
    }

    public function addUserRole(User $userRole): static
    {
        if (!$this->user_role->contains($userRole)) {
            $this->user_role->add($userRole);
            $userRole->setRole($this);
        }

        return $this;
    }

    public function removeUserRole(User $userRole): static
    {
        if ($this->user_role->removeElement($userRole)) {
            // set the owning side to null (unless already changed)
            if ($userRole->getRole() === $this) {
                $userRole->setRole(null);
            }
        }

        return $this;
    }
}
