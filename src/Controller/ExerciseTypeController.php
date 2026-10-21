<?php

namespace App\Controller;

use App\Entity\ExerciseType;
use App\Form\ExerciseTypeType;
use App\Repository\ExerciseTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exercise-type')]
final class ExerciseTypeController extends AbstractController
{
    #[Route(name: 'app_exercise_type_index', methods: ['GET'])]
    public function index(ExerciseTypeRepository $exerciseTypeRepository): Response
    {
        return $this->render('exercise_type/index.html.twig', [
            'exercise_types' => $exerciseTypeRepository->findBy([], ['name' => 'ASC'])
        ]);
    }

    #[Route('/new', name: 'app_exercise_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exerciseType = new ExerciseType();
        $form = $this->createForm(ExerciseTypeType::class, $exerciseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exerciseType);
            $entityManager->flush();

            return $this->redirectToRoute('app_exercise_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercise_type/new.html.twig', [
            'exercise_type' => $exerciseType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercise_type_show', methods: ['GET'])]
    public function show(ExerciseType $exerciseType): Response
    {
        return $this->render('exercise_type/show.html.twig', [
            'exercise_type' => $exerciseType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exercise_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExerciseType $exerciseType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciseTypeType::class, $exerciseType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exercise_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exercise_type/edit.html.twig', [
            'exercise_type' => $exerciseType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exercise_type_delete', methods: ['POST'])]
    public function delete(Request $request, ExerciseType $exerciseType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exerciseType->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exerciseType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exercise_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
