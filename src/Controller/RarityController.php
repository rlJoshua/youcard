<?php

namespace App\Controller;

use App\Entity\Rarity;
use App\Form\RarityType;
use App\Repository\RarityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RarityController extends AbstractController
{


    private $rarityRepository;
    private $entityManager;

    public function __construct(RarityRepository $rarityRepository, EntityManagerInterface $entityManager)
    {
        $this->rarityRepository = $rarityRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/rarity", name="list_rarity")
     */
    public function index()
    {
        $rarities = $this->rarityRepository->findAll();

        return $this->render('layout/index.html.twig', [
            "rarities" => $rarities,
            "title" => "Raretés"
        ]);
    }

    /**
     * @Route("/add_rarity", name="add_rarity")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createRarity(Request $request){

        $rarity = new Rarity();
        $form = $this->createForm(RarityType::class, $rarity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->entityManager->persist($rarity);
            $this->entityManager->flush();

            return new  Response();
        }

        $rarities = $this->rarityRepository->findAll();

        return $this->render('layout/form.html.twig',[
            "form" => $form->createView(),
            "title" => "Rareté",
            "sub_title" => "Ajouter une rareté",
            'rarities' => $rarities
        ]);
    }

    /**
     * @Route("/update_rarity/{id}", name="update_rarity")
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function updateRarity(Request $request, int $id){

        // Get all data form
        $rarity = $this->rarityRepository->find($id);

        $form = $this->createForm(RarityType::class, $rarity);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Add Factions in database
            $this->entityManager->persist($rarity);
            $this->entityManager->flush();

            return new Response();
        }

        return $this->render('layout/show.html.twig',[
            "form" => $form->createView(),
            "title" => "Rarity",
            "id" => $rarity->getId(),
            "rarity" => $rarity
        ]);
    }

}
