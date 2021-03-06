<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RarityRepository")
 */
class Rarity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="rarety")
     */
    private $cards;


    public function __construct()
    {
        $this->cards = new ArrayCollection();
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addFaction(Card $faction): self
    {
        if (!$this->cards->contains($faction)) {
            $this->cards[] = $faction;
            $faction->setRarity($this);
        }

        return $this;
    }

    public function removeCard(Card $faction): self
    {
        if ($this->cards->contains($faction)) {
            $this->cards->removeElement($faction);
            // set the owning side to null (unless already changed)
            if ($faction->getRarity() === $this) {
                $faction->setRarity(null);
            }
        }

        return $this;
    }
}
