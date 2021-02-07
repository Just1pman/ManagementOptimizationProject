<?php

namespace App\Controller;

use App\Entity\SpokenLanguage;
use App\Form\SpokenLanguageType;
use App\Repository\SpokenLanguageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spoken/language")
 *
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */
class SpokenLanguageController extends AbstractController
{
    /**
     * Require ROLE_ADMIN for only this controller method.
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
    }

    /**
     * @Route("/", name="spoken_language_index", methods={"GET"})
     * @param SpokenLanguageRepository $spokenLanguageRepository
     * @return Response
     */
    public function index(SpokenLanguageRepository $spokenLanguageRepository): Response
    {
        return $this->render('spoken_language/index.html.twig', [
            'spoken_languages' => $spokenLanguageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="spoken_language_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $spokenLanguage = new SpokenLanguage();
        $form = $this->createForm(SpokenLanguageType::class, $spokenLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spokenLanguage);
            $entityManager->flush();

            return $this->redirectToRoute('spoken_language_index');
        }

        return $this->render('spoken_language/new.html.twig', [
            'spoken_language' => $spokenLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spoken_language_show", methods={"GET"})
     */
    public function show(SpokenLanguage $spokenLanguage): Response
    {
        return $this->render('spoken_language/show.html.twig', [
            'spoken_language' => $spokenLanguage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spoken_language_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SpokenLanguage $spokenLanguage): Response
    {
        $form = $this->createForm(SpokenLanguageType::class, $spokenLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spoken_language_index');
        }

        return $this->render('spoken_language/edit.html.twig', [
            'spoken_language' => $spokenLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spoken_language_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SpokenLanguage $spokenLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spokenLanguage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spokenLanguage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spoken_language_index');
    }
}
