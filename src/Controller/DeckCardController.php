<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DeckCardController extends AbstractController
{
    /**
     * @Route("/deck/card", name="deck_card")
     */
    public function index()
    {
        return $this->render('deck_card/index.html.twig', [
            'controller_name' => 'DeckCardController',
        ]);
    }
}
