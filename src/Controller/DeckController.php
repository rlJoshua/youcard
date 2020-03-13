<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\DeckCard;
use App\Form\DeckType;
use App\Repository\CardRepository;
use App\Repository\DeckCardRepository;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{

    private $deckRepository;
    private $cardRepository;
    private $deckCardRepository;
    private $entityManager;

    public function __construct(
        DeckRepository $deckRepository,
        EntityManagerInterface $entityManager,
        CardRepository $cardRepository,
        DeckCardRepository $deckCardRepository)
    {
        $this->entityManager = $entityManager;
        $this->deckRepository = $deckRepository;
        $this->cardRepository = $cardRepository;
        $this->deckCardRepository = $deckCardRepository;

    }

    /**
     * @Route("/deck", name="list_decks")
     */
    public function index()
    {
        $decks = $this->deckRepository->findBy(array("user" => $this->getUser()->getId()));

        return $this->render('layout/index.html.twig', [
            'decks' => $decks,
            'title' => "Decks"
        ]);
    }

    /**
     * @Route("/deck/add", name="add_deck")
     * @param Request $request
     * @return Response
     */
    public function createDeck(Request $request){

        // Get all data form
        $deck = new Deck();
        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        $deck->setUser($this->getUser());

        if($form->isSubmitted() && $form->isValid()){

            // Add Deck in database
            $this->entityManager->persist($deck);
            $this->entityManager->flush();

            return new Response();
        }

        $decks = $this->deckRepository->findBy(array("user" => $this->getUser()->getId()));

        return $this->render('layout/form.html.twig',[
            "form" => $form->createView(),
            "title" => "Decks",
            "sub_title" => "Ajouter un deck",
            'decks' => $decks
        ]);
    }


    /**
     * @Route("/update_deck/{id}", name="update_deck")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function updateFaction(Request $request, int $id){

        // Get all data form
        $deck = $this->deckRepository->find($id);

        $form = $this->createForm(DeckType::class, $deck);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Add Factions in database
            $this->entityManager->persist($deck);
            $this->entityManager->flush();

            return new Response();
        }

        return $this->render('layout/show.html.twig',[
            "form" => $form->createView(),
            "title" => "decks",
            "id" => $deck->getId(),
            "deck" => $deck
        ]);
    }

    /**
     * @Route("/remove_deck/{id}", name="remove_deck")
     * @param Request $request
     * @param int $id
     * @ParamConverter("deck", options={"mapping"={"id"="id"}})
     * @return RedirectResponse|Response
     */
    public function removeDeck(Request $request, int $id){

        // Get all data form
        $deck = $this->deckRepository->find($id);

        $deckcards = $this->deckCardRepository->findBy(array("deck" => $deck->getId()));

        // Remove card of faction in database
        foreach($deckcards as $deckcard){
            $this->entityManager->remove($deckcard);
        }

        // Remove faction in database
        $this->entityManager->remove($deck);
        $this->entityManager->flush();

        // Get list factions
        $decks = $this->deckRepository->findAll();

        return $this->render('layout/index.html.twig',[
            "title" => "Decks",
            "decks" => $decks
        ]);
    }



}
