<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users", name="list_users")
     */
    public function index()
    {
        $users = $this->userRepository->findAll();
        return $this->render('user/index.html.twig', [
            "users" => $users
        ]);
    }

}
