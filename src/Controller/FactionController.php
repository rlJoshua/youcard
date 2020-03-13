<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionType;
use App\Repository\CardRepository;
use App\Repository\FactionRepository;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactionController extends AbstractController
{

    private $factionRepository;
    private $cardRepository;
    private $entityManager;

    public function __construct(FactionRepository $factionRepository, EntityManagerInterface $entityManager, CardRepository $cardRepository)
    {
        $this->factionRepository = $factionRepository;
        $this->cardRepository = $cardRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/faction", name="list_factions")
     */
    public function index()
    {
        $factions = $this->factionRepository->findAll();

        return $this->render('layout/index.html.twig', [
            'factions' => $factions,
            "title" => "Factions"
        ]);
    }


    /**
     * @Route("/add_faction", name="add_faction")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function createFaction(Request $request){

        // Get all data form
        $faction = new Faction();

        $form = $this->createForm(FactionType::class, $faction);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Add Factions in database
            $this->entityManager->persist($faction);
            $this->entityManager->flush();

            return new Response();
        }

        $factions = $this->factionRepository->findAll();

        return $this->render('layout/form.html.twig',[
            "form" => $form->createView(),
            "title" => "Factions",
            "sub_title" => "Ajouter une faction",
            "factions" => $factions
        ]);
    }


    /**
     * @Route("/update_faction/{id}", name="update_faction")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function updateFaction(Request $request, int $id){

        // Get all data form
        $faction = $this->factionRepository->find($id);

        $form = $this->createForm(FactionType::class, $faction);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Add Factions in database
            $this->entityManager->persist($faction);
            $this->entityManager->flush();

            return new Response();
        }

        return $this->render('layout/show.html.twig',[
            "form" => $form->createView(),
            "title" => "Factions",
            "id" => $faction->getId(),
            "faction" => $faction
        ]);
    }

    /**
     * @Route("/remove_faction/{id}", name="remove_faction")
     * @param Request $request
     * @param int $id
     * @ParamConverter("faction", options={"mapping"={"id"="id"}})
     * @return RedirectResponse|Response
     */
    public function removeFaction(Request $request, int $id){

        // Get all data form
        $faction = $this->factionRepository->find($id);

        $cards = $this->cardRepository->findBy(array("faction" => $faction->getId()));

        // Remove card of faction in database
        foreach($cards as $card){
            $this->entityManager->remove($card);
        }
         // Remove faction in database
        $this->entityManager->remove($faction);
        $this->entityManager->flush();

        // Get list factions
        $factions = $this->factionRepository->findAll();

        return $this->render('layout/index.html.twig',[
            "title" => "Factions",
            "factions" => $factions
        ]);
    }
}
