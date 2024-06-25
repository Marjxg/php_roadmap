<?php

namespace App\Entity;

use App\Repository\SubsidiaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubsidiaryRepository::class)]
class Subsidiary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'subsidiary_municipio')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Municipio $municipio = null;

    #[ORM\OneToMany(mappedBy: 'subsidiary', targetEntity: User::class)]
    private Collection $user_subsidiary;

    #[ORM\OneToMany(mappedBy: 'subsidiary', targetEntity: Transaction::class)]
    private Collection $transaction_subs;

    public function __construct()
    {
        $this->user_subsidiary = new ArrayCollection();
        $this->transaction_subs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getMunicipio(): ?Municipio
    {
        return $this->municipio;
    }

    public function setMunicipio(?Municipio $municipio): static
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserSubsidiary(): Collection
    {
        return $this->user_subsidiary;
    }

    public function addUserSubsidiary(User $userSubsidiary): static
    {
        if (!$this->user_subsidiary->contains($userSubsidiary)) {
            $this->user_subsidiary->add($userSubsidiary);
            $userSubsidiary->setSubsidiary($this);
        }

        return $this;
    }

    public function removeUserSubsidiary(User $userSubsidiary): static
    {
        if ($this->user_subsidiary->removeElement($userSubsidiary)) {
            // set the owning side to null (unless already changed)
            if ($userSubsidiary->getSubsidiary() === $this) {
                $userSubsidiary->setSubsidiary(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionSubs(): Collection
    {
        return $this->transaction_subs;
    }

    public function addTransactionSub(Transaction $transactionSub): static
    {
        if (!$this->transaction_subs->contains($transactionSub)) {
            $this->transaction_subs->add($transactionSub);
            $transactionSub->setSubsidiary($this);
        }

        return $this;
    }

    public function removeTransactionSub(Transaction $transactionSub): static
    {
        if ($this->transaction_subs->removeElement($transactionSub)) {
            // set the owning side to null (unless already changed)
            if ($transactionSub->getSubsidiary() === $this) {
                $transactionSub->setSubsidiary(null);
            }
        }

        return $this;
    }
}
