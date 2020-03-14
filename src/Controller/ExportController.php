<?php

namespace App\Controller;

use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportController extends AbstractController
{

    private $entityManager;
    private $cardRepository;

    function __construct(EntityManagerInterface $entityManager, CardRepository $cardRepository)
    {
        $this->entityManager = $entityManager;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/export_cards", name="export_cards")
     * @param Request $request
     * @return Response
     */
    public function exportCards(Request $request)
    {

        $cards = $this->cardRepository->findAll();

        $export = fopen("php://output", "r+");

        foreach ($cards as $card){

            $array = $card->arrayExport();

            if (!empty($array["image"])){

                $image = new File($this->getParameter('cards_folder')."/".$array["image"]);
            }
            else{

                $image = new File($this->getParameter('img_folder')."/empty.jpg");
            }

            $array["image"] = base64_encode($image);

            fputcsv($export, $array);
        }

        fclose($export);

        $response = new Response();

        $response->headers->set("Content-Type", "text/csv");
        $response->headers->set("Content-Disposition", "attachment; filename='export.csv'");

        return $response;

    }
}
