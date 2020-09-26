<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;

class PinsController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PinRepository $repo)
    {
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }
}
