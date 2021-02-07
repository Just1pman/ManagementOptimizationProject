<?php

namespace App\Controller;

use App\Entity\TechnicalExperience;
use App\Form\TechnicalExperienceType;
use App\Repository\TechnicalExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/technical/experience")
 */
class TechnicalExperienceController extends AbstractController
{
    /**
     * @Route("/", name="technical_experience_index", methods={"GET"})
     * @param TechnicalExperienceRepository $technicalExperienceRepository
     * @return Response
     */
    public function index(TechnicalExperienceRepository $technicalExperienceRepository): Response
    {
        return $this->render('technical_experience/index.html.twig', [
            'technical_experiences' => $technicalExperienceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="technical_experience_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $technicalExperience = new TechnicalExperience();
        $form = $this->createForm(TechnicalExperienceType::class, $technicalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technicalExperience);
            $entityManager->flush();

            return $this->redirectToRoute('technical_experience_index');
        }

        return $this->render('technical_experience/new.html.twig', [
            'technical_experience' => $technicalExperience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technical_experience_show", methods={"GET"})
     */
    public function show(TechnicalExperience $technicalExperience): Response
    {
        return $this->render('technical_experience/show.html.twig', [
            'technical_experience' => $technicalExperience,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="technical_experience_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TechnicalExperience $technicalExperience): Response
    {
        $form = $this->createForm(TechnicalExperienceType::class, $technicalExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technical_experience_index');
        }

        return $this->render('technical_experience/edit.html.twig', [
            'technical_experience' => $technicalExperience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="technical_experience_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TechnicalExperience $technicalExperience): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technicalExperience->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($technicalExperience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('technical_experience_index');
    }
}
