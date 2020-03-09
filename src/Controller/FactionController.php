<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionType;
use App\Repository\FactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FactionController extends AbstractController
{

    private $factionRepository;
    private $entityManager;

    public function __construct(FactionRepository $factionRepository, EntityManagerInterface $entityManager)
    {
        $this->factionRepository = $factionRepository;
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
     * @Route("/faction/add", name="add_faction")
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
}
