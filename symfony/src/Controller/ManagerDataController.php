<?php

namespace App\Controller;

use App\Entity\ManagerData;
use App\Form\ManagerDataType;
use App\Repository\ManagerDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/manager/data")
 */
class ManagerDataController extends AbstractController
{
    /**
     * @Route("/", name="manager_data_index", methods={"GET"})
     */
    public function index(ManagerDataRepository $managerDataRepository): Response
    {
        return $this->render('manager_data/index.html.twig', [
            'manager_datas' => $managerDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="manager_data_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $managerDatum = new ManagerData();
        $form = $this->createForm(ManagerDataType::class, $managerDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($managerDatum);
            $entityManager->flush();

            return $this->redirectToRoute('manager_data_index');
        }

        return $this->render('manager_data/new.html.twig', [
            'manager_datum' => $managerDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manager_data_show", methods={"GET"})
     */
    public function show(ManagerData $managerDatum): Response
    {
        return $this->render('manager_data/show.html.twig', [
            'manager_datum' => $managerDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="manager_data_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ManagerData $managerDatum): Response
    {
        $form = $this->createForm(ManagerDataType::class, $managerDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manager_data_index');
        }

        return $this->render('manager_data/edit.html.twig', [
            'manager_datum' => $managerDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="manager_data_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ManagerData $managerDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$managerDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($managerDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manager_data_index');
    }
}
