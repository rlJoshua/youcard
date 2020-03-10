<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\DeckCard;
use App\Form\DeckType;
use App\Repository\CardRepository;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{

    private $deckRepository;
    private $cardRepository;
    private $entityManager;

    public function __construct(DeckRepository $deckRepository, EntityManagerInterface $entityManager, CardRepository $cardRepository)
    {
        $this->entityManager = $entityManager;
        $this->deckRepository = $deckRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/deck", name="list_decks")
     */
    public function index()
    {
        $decks = $this->deckRepository->findAll();

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


        if($form->isSubmitted() && $form->isValid()){

            // Add Deck in database
            $this->entityManager->persist($deck);
            $this->entityManager->flush();

            return new Response();
        }

        $decks = $this->deckRepository->findAll();

        return $this->render('layout/form.html.twig',[
            "form" => $form->createView(),
            "title" => "Decks",
            "sub_title" => "Ajouter un deck",
            'decks' => $decks
        ]);
    }




}
