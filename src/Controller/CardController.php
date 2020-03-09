<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{

    private $cardRepository;
    private $entityManager;

    public function __construct(CardRepository $cardRepository, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/card", name="list_cards")
     */
    public function index()
    {
        $cards = $this->cardRepository->findAll();

        return $this->render('layout/index.html.twig', [
            'cards' => $cards,
            "title" => "Cards"
        ]);
    }

    /**
     * @Route("/card/add", name="add_card")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createCard(Request $request){

        // Get all data form
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Add User in Card
            $card->setCreator($this->getUser());

            if ($form->get("image")->getData() !== null){

                // Add image file
                $image = $form->get("image")->getData();
                $date = new \DateTime();

                $imageName = "card_".$date->format('Y-m-d-H-i-s').".".$image->guessExtension();
                $image->move($this->getParameter('cards_folder'), $imageName);

                $card->setImage($imageName);
            }
            else{

                // Set empty value
                $card->setImage("");
            }

            // Add Cards in database
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            return new Response();
        }

        $cards = $this->cardRepository->findAll();

        return $this->render('layout/form.html.twig',[
            "form" => $form->createView(),
            "title" => "Cards",
            "sub_title" => "Ajouter une carte",
            'cards' => $cards
        ]);
    }
}
