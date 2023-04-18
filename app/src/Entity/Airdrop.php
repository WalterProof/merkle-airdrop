<?php

namespace App\Entity;

use App\Repository\AirdropRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirdropRepository::class)]
class Airdrop
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'airdrop', targetEntity: AirdropUser::class, orphanRemoval: true)]
    private Collection $airdropUsers;

    public function __construct()
    {
        $this->airdropUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, AirdropUser>
     */
    public function getAirdropUsers(): Collection
    {
        return $this->airdropUsers;
    }

    public function addAirdropUser(AirdropUser $airdropUser): self
    {
        if (!$this->airdropUsers->contains($airdropUser)) {
            $this->airdropUsers->add($airdropUser);
            $airdropUser->setAirdrop($this);
        }

        return $this;
    }

    public function removeAirdropUser(AirdropUser $airdropUser): self
    {
        if ($this->airdropUsers->removeElement($airdropUser)) {
            // set the owning side to null (unless already changed)
            if ($airdropUser->getAirdrop() === $this) {
                $airdropUser->setAirdrop(null);
            }
        }

        return $this;
    }
}
