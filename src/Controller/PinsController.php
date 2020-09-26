<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PinsController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PinRepository $repo)
    {
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }

    /**
     * @Route("/pins/create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $pin = new Pin();
            $pin->setTitle($data['title']);
            $pin->setDescription(($data['description']));

            $em->persist($pin);
            $em->flush();

            return $this->redirect("/");
        }
        
        return $this->render('pins/create.html.twig');
    }
}
