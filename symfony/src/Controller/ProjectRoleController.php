<?php

namespace App\Controller;

use App\Entity\ProjectRole;
use App\Form\ProjectRoleType;
use App\Repository\ProjectRoleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project/role")
 *
 * Require ROLE_MANAGER for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */
class ProjectRoleController extends AbstractController
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
     * @Route("/", name="project_role_index", methods={"GET"})
     */
    public function index(ProjectRoleRepository $projectRoleRepository): Response
    {
        return $this->render('project_role/index.html.twig', [
            'project_roles' => $projectRoleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="project_role_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projectRole = new ProjectRole();
        $form = $this->createForm(ProjectRoleType::class, $projectRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projectRole);
            $entityManager->flush();

            return $this->redirectToRoute('project_role_index');
        }

        return $this->render('project_role/new.html.twig', [
            'project_role' => $projectRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_role_show", methods={"GET"})
     */
    public function show(ProjectRole $projectRole): Response
    {
        return $this->render('project_role/show.html.twig', [
            'project_role' => $projectRole,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_role_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProjectRole $projectRole): Response
    {
        $form = $this->createForm(ProjectRoleType::class, $projectRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_role_index');
        }

        return $this->render('project_role/edit.html.twig', [
            'project_role' => $projectRole,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="project_role_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProjectRole $projectRole): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projectRole->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projectRole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_role_index');
    }
}
