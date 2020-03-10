<?php

namespace App\Controller;

use App\Entity\Card;
use App\Entity\Deck;
use App\Entity\DeckCard;
use App\Repository\CardRepository;
use App\Repository\DeckCardRepository;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckCardController extends AbstractController
{

    private $deckCardRepository;
    private $deckRepository;
    private $cardRepository;
    private $entityManager;

    public function __construct(
        DeckCardRepository $deckCardRepository,
        EntityManagerInterface $entityManager,
        DeckRepository $deckRepository,
        CardRepository $cardRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->deckCardRepository = $deckCardRepository;
        $this->deckRepository = $deckRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/get_deckcard/{id}", name="get_deck")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function getDeck(Request $request, int $id){

        $deck = $this->deckRepository->find($id);
        $cards = $this->cardRepository ->findAll();

        $deck_cards = $this->deckCardRepository->findBy(array("deck" => $id));

        return $this->render('layout/view.html.twig', [
            'deck' => $deck,
            "deckcards" => $deck_cards,
            "cards" => $cards
        ]);
    }

    /**
     * @Route("/set_deckcard/{id_deck}/{id_card}", name="set_deck")
     * @param int $id_deck
     * @param int $id_card
     * @return Response
     * @ParamConverter("deck", options={"mapping"={"id"="id_deck"}})
     * @ParamConverter("card", options={"mapping"={"id"="id_card"}})
     */
    public function setDeck(int $id_deck, int $id_card){

        $deck = $this->deckRepository->find($id_deck);
        $card = $this->cardRepository->find($id_card);

        $deckcard = new DeckCard();

        $card->addDeckCard($deckcard);
        $deck->addDeckCard($deckcard);

        $this->entityManager->persist($deckcard);
        $this->entityManager->flush();

        $deck_cards = $this->deckCardRepository->findBy(["deck" => $id_deck]);
        $cards = $this->cardRepository->findAll();

        return $this->render('layout/view.html.twig', [
            'deck' => $deck,
            "deckcards" => $deck_cards,
            "cards" => $cards
        ]);
    }


    /**
     * @Route("/remove_deckcard/{id}", name="remove_deckcard")
     * @ParamConverter("deckcard", options={"mapping"={"id"="id"}})
     * @param int $id
     * @return Response
     */
    public function removeCard(int $id){

        $deckcard = $this->deckCardRepository->find($id);

        $id_deck = $deckcard->getDeck()->getId();
        $this->entityManager->remove($deckcard);
        $this->entityManager->flush();

        $deck_cards = $this->deckCardRepository->findBy(["deck" => $id_deck]);
        $deck = $this->deckRepository->find($id_deck);
        $cards = $this->cardRepository->findAll();

        return $this->render('layout/view.html.twig', [
            'deck' => $deck,
            "deckcards" => $deck_cards,
            "cards" => $cards
        ]);
    }


}
