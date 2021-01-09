<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/skill")
 *
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */
class SkillController extends AbstractController
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
     * @Route("/", name="skill_index", methods={"GET"})
     */
    public function index(SkillRepository $skillRepository): Response
    {
        return $this->render('skill/index.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="skill_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('skill_index');
        }

        return $this->render('skill/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_show", methods={"GET"})
     */
    public function show(Skill $skill): Response
    {
        return $this->render('skill/show.html.twig', [
            'skill' => $skill,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="skill_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Skill $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('skill_index');
        }

        return $this->render('skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="skill_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skill $skill): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('skill_index');
    }
}
