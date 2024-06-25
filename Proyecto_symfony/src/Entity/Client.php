<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $corporate_name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\ManyToOne(inversedBy: 'user_doc_types')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DocType $docType = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Account::class, orphanRemoval: true)]
    private Collection $client_accounts;

    #[ORM\ManyToOne(inversedBy: 'client_municipio')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Municipio $municipio = null;

    #[ORM\Column(length: 25)]
    private ?string $doc_num = null;

    public function __construct()
    {
        $this->client_accounts = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getCorporateName(): ?string
    {
        return $this->corporate_name;
    }

    public function setCorporateName(?string $corporate_name): static
    {
        $this->corporate_name = $corporate_name;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): static
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getDocType(): ?DocType
    {
        return $this->docType;
    }

    public function setDocType(?DocType $docType): static
    {
        $this->docType = $docType;

        return $this;
    }

    /**
     * @return Collection<int, Account>
     */
    public function getClientAccounts(): Collection
    {
        return $this->client_accounts;
    }

    public function addClientAccount(Account $clientAccount): static
    {
        if (!$this->client_accounts->contains($clientAccount)) {
            $this->client_accounts->add($clientAccount);
            $clientAccount->setClient($this);
        }

        return $this;
    }

    public function removeClientAccount(Account $clientAccount): static
    {
        if ($this->client_accounts->removeElement($clientAccount)) {
            // set the owning side to null (unless already changed)
            if ($clientAccount->getClient() === $this) {
                $clientAccount->setClient(null);
            }
        }

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

    public function getDocNum(): ?string
    {
        return $this->doc_num;
    }

    public function setDocNum(string $doc_num): static
    {
        $this->doc_num = $doc_num;

        return $this;
    }
}
