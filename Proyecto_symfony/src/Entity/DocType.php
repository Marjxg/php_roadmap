<?php

namespace App\Entity;

use App\Repository\DocTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocTypeRepository::class)]
class DocType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'docType', targetEntity: Client::class)]
    private Collection $user_doc_types;

    public function __construct()
    {
        $this->user_doc_types = new ArrayCollection();
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

    /**
     * @return Collection<int, Client>
     */
    public function getUserDocTypes(): Collection
    {
        return $this->user_doc_types;
    }

    public function addUserDocType(Client $userDocType): static
    {
        if (!$this->user_doc_types->contains($userDocType)) {
            $this->user_doc_types->add($userDocType);
            $userDocType->setDocType($this);
        }

        return $this;
    }

    public function removeUserDocType(Client $userDocType): static
    {
        if ($this->user_doc_types->removeElement($userDocType)) {
            // set the owning side to null (unless already changed)
            if ($userDocType->getDocType() === $this) {
                $userDocType->setDocType(null);
            }
        }

        return $this;
    }
}
