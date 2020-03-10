<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeckCardRepository")
 */
class DeckCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="deckCards", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $card;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Deck", inversedBy="deckCards", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $deck;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getDeck(): ?Deck
    {
        return $this->deck;
    }

    public function setDeck(?Deck $deck): self
    {
        $this->deck = $deck;

        return $this;
    }
}
