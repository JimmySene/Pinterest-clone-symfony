<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PinsController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $repo)
    {
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }

    /**
     * @Route("/pins/create", methods="GET|POST")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $pin = new Pin();

        $form = $this->createFormBuilder($pin)
        ->add('title')
        ->add('description', null, ['attr'=>['cols'=>50, 'rows' => 10]])
        ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        

        return $this->render('pins/create.html.twig', ['pinsForm' => $form->createView()]);
    }
}
