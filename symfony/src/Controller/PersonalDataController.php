<?php

namespace App\Controller;

use App\Entity\PersonalData;
use App\Form\PersonalDataType;
use App\Repository\PersonalDataRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personal/data")
 *
 * Require ROLE_MANAGER for *every* controller method in this class.
 * @IsGranted("ROLE_MANAGER")
 */
class PersonalDataController extends AbstractController
{
    /**
     * @Route("/", name="personal_data_index", methods={"GET"})
     * @param PersonalDataRepository $personalDataRepository
     * @return Response
     */
    public function index(PersonalDataRepository $personalDataRepository): Response
    {
        return $this->render('personal_data/index.html.twig', [
            'personal_datas' => $personalDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personal_data_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $personalDatum = new PersonalData();
        $form = $this->createForm(PersonalDataType::class, $personalDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personalDatum);
            $entityManager->flush();

            return $this->redirectToRoute('personal_data_index');
        }

        return $this->render('personal_data/new.html.twig', [
            'personal_datum' => $personalDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personal_data_show", methods={"GET"})
     * @param PersonalData $personalDatum
     * @return Response
     */
    public function show(PersonalData $personalDatum): Response
    {
        return $this->render('personal_data/show.html.twig', [
            'personal_datum' => $personalDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personal_data_edit", methods={"GET","POST"})
     * @param Request $request
     * @param PersonalData $personalDatum
     * @return Response
     */
    public function edit(Request $request, PersonalData $personalDatum): Response
    {
        $form = $this->createForm(PersonalDataType::class, $personalDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personal_data_index');
        }

        return $this->render('personal_data/edit.html.twig', [
            'personal_datum' => $personalDatum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personal_data_delete", methods={"DELETE"})
     * @param Request $request
     * @param PersonalData $personalDatum
     * @return Response
     */
    public function delete(Request $request, PersonalData $personalDatum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personalDatum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personalDatum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personal_data_index');
    }
}
