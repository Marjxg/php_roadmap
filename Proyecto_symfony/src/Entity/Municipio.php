<?php

namespace App\Entity;

use App\Repository\MunicipioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MunicipioRepository::class)]
class Municipio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'municipios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departamento $departamento = null;

    #[ORM\OneToMany(mappedBy: 'municipio', targetEntity: Client::class)]
    private Collection $client_municipio;

    #[ORM\OneToMany(mappedBy: 'municipio', targetEntity: Subsidiary::class)]
    private Collection $subsidiary_municipio;

    public function __construct()
    {
        $this->client_municipio = new ArrayCollection();
        $this->subsidiary_municipio = new ArrayCollection();
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

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): static
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClientMunicipio(): Collection
    {
        return $this->client_municipio;
    }

    public function addClientMunicipio(Client $clientMunicipio): static
    {
        if (!$this->client_municipio->contains($clientMunicipio)) {
            $this->client_municipio->add($clientMunicipio);
            $clientMunicipio->setMunicipio($this);
        }

        return $this;
    }

    public function removeClientMunicipio(Client $clientMunicipio): static
    {
        if ($this->client_municipio->removeElement($clientMunicipio)) {
            // set the owning side to null (unless already changed)
            if ($clientMunicipio->getMunicipio() === $this) {
                $clientMunicipio->setMunicipio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Subsidiary>
     */
    public function getSubsidiaryMunicipio(): Collection
    {
        return $this->subsidiary_municipio;
    }

    public function addSubsidiaryMunicipio(Subsidiary $subsidiaryMunicipio): static
    {
        if (!$this->subsidiary_municipio->contains($subsidiaryMunicipio)) {
            $this->subsidiary_municipio->add($subsidiaryMunicipio);
            $subsidiaryMunicipio->setMunicipio($this);
        }

        return $this;
    }

    public function removeSubsidiaryMunicipio(Subsidiary $subsidiaryMunicipio): static
    {
        if ($this->subsidiary_municipio->removeElement($subsidiaryMunicipio)) {
            // set the owning side to null (unless already changed)
            if ($subsidiaryMunicipio->getMunicipio() === $this) {
                $subsidiaryMunicipio->setMunicipio(null);
            }
        }

        return $this;
    }
}
