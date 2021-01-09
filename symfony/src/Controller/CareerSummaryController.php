<?php

namespace App\Controller;

use App\Entity\CareerSummary;
use App\Form\CareerSummaryType;
use App\Repository\CareerSummaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/career/summary")
 */
class CareerSummaryController extends AbstractController
{
    /**
     * @Route("/", name="career_summary_index", methods={"GET"})
     * @param CareerSummaryRepository $careerSummaryRepository
     * @return Response
     */
    public function index(CareerSummaryRepository $careerSummaryRepository): Response
    {
        return $this->render('career_summary/index.html.twig', [
            'career_summaries' => $careerSummaryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="career_summary_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $careerSummary = new CareerSummary();
        $form = $this->createForm(CareerSummaryType::class, $careerSummary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($careerSummary);
            $entityManager->flush();

            return $this->redirectToRoute('career_summary_index');
        }

        return $this->render('career_summary/new.html.twig', [
            'career_summary' => $careerSummary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="career_summary_show", methods={"GET"})
     * @param CareerSummary $careerSummary
     * @return Response
     */
    public function show(CareerSummary $careerSummary): Response
    {
        return $this->render('career_summary/show.html.twig', [
            'career_summary' => $careerSummary,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="career_summary_edit", methods={"GET","POST"})
     * @param Request $request
     * @param CareerSummary $careerSummary
     * @return Response
     */
    public function edit(Request $request, CareerSummary $careerSummary): Response
    {
        $form = $this->createForm(CareerSummaryType::class, $careerSummary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('career_summary_index');
        }

        return $this->render('career_summary/edit.html.twig', [
            'career_summary' => $careerSummary,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="career_summary_delete", methods={"DELETE"})
     * @param Request $request
     * @param CareerSummary $careerSummary
     * @return Response
     */
    public function delete(Request $request, CareerSummary $careerSummary): Response
    {
        if ($this->isCsrfTokenValid('delete'.$careerSummary->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($careerSummary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('career_summary_index');
    }
}
