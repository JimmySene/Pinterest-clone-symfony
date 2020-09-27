<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
        $form = $this->createFormBuilder()
        ->add('title')
        ->add('description', TextareaType::class)
        ->add('submit', SubmitType::class, ['label' => 'envoyer'])
        ->getForm();

        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $pin = new Pin();
            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        

        return $this->render('pins/create.html.twig', ['pinsForm' => $form->createView()]);
    }
}
