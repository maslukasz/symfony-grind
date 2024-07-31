<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TaskController extends AbstractController
{
    public function test(): Response
    {
        return $this->render('test.html.twig');
    }

    #[Route('/testy')]
    public function new(Request $request, EntityManager $entityManager): Response
    {
        $task = new Task();
        // $task->setTitle('Title');

        $form = $this->createFormBuilder($task)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($form->getData());

            $entityManager->flush();
        }

        return $this->render('test.html.twig', [
            'form' => $form
        ]);
    }
}