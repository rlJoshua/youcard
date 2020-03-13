<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
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
     * @Route("/add_card", name="add_card")
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
            "title" => "Cartes",
            "sub_title" => "Ajouter une carte",
            'cards' => $cards
        ]);
    }


    /**
     * @Route("/update_card/{id}", name="update_card")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Exception
     */
    public function updateCard(Request $request, int $id){

        $card = $this->cardRepository->find($id);

        if (!empty($card->getImage())){
            $image = new File($this->getParameter('cards_folder')."/".$card->getImage());
        }
        else{
            $image = new File($this->getParameter('img_folder')."/empty.jpg");
        }

        $imgName = $card->getImage();

        $card->setImage($image);

        $form = $this->createForm(CardType::class, $card);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if ($form->get("image")->getData() !== null){

                // Add image file
                $image = $form->get("image")->getData();
                $date = new \DateTime();

                $imageName = "card_".$date->format('Y-m-d-H-i-s').".".$image->guessExtension();
                $image->move($this->getParameter('cards_folder'), $imageName);

                $card->setImage($imageName);
            }
            else{

                if (!empty($imgName) || $imgName !== null){

                    // Set old value
                    $card->setImage($imgName);
                }
                else{

                    // Set empty value
                    $card->setImage("");
                }
            }

            // Add Cards in database
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            return new Response();
        }

        return $this->render('layout/show.html.twig',[
            "form" => $form->createView(),
            "card" => $card,
            "id" => $card->getId(),
            "title" => "Ajouter une carte",
            "img" => $imgName
        ]);
    }


    /**
     * @Route("/remove_card/{id}", name="remove_card")
     * @ParamConverter("card", options={"mapping"={"id"="id"}})
     * @param int $id
     * @return Response
     */
    public function removeCard(int $id){

        $card = $this->cardRepository->find($id);

        $this->entityManager->remove($card);
        $this->entityManager->flush();


        $cards = $this->cardRepository->findAll();

        return $this->render('layout/index.html.twig', [
            "card" => $cards,
            "title" => "Cards"
        ]);
    }
}
