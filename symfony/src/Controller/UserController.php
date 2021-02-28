<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf as Dompdf;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    private function addTemporaryCollection(Collection $collection, $temporaryCollection)
    {
        foreach ($collection as $element) {
            $temporaryCollection->add($element);
        }
        return $this;
    }

    private function removeFromCollection($temporaryCollection, $collection, EntityManager $em)
    {
        foreach ($temporaryCollection as $temporaryElement) {
            if ($collection->contains($temporaryElement) === false) {
                $em->remove($temporaryElement);
            }
        }
        return $this;
    }

    /**
     * @Route("/my_profile", name="my_profile", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function myProfile(UserRepository $userRepository): Response
    {
        $data = $this->getUser()->getUsername();
        $user = $userRepository->findOneBy(['email' => "$data"]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route ("/summary/{id}", name="user_summary", methods={"GET","POST"})
     * @param User $user
     * @return Response
     */
    public function userSummary(User $user): Response
    {
        $dompdf = new Dompdf();
        $dompdf->setPaper('A4');
        $html = $this->render('user/summary.html.twig', ['user' => $user]);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('Summary.pdf',
            [
                'Attachment' => 0,
            ]);

        return new Response('');
    }

    /**
     * Require ROLE_USER for only this controller method.
     * @IsGranted("ROLE_USER")
     *
     * @Route("/register", name="user_register", methods={"GET","POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     * @throws Exception
     */
    public function register(Request $request, UserRepository $userRepository): Response
    {
        $temporaryEducationCollection = new ArrayCollection();
        $temporaryLanguageCollection = new ArrayCollection();
        $temporaryCareerCollection = new ArrayCollection();
        $temporaryTechnicalExperienceCollection = new ArrayCollection();

        $data = $this->getUser()->getUsername();
        $user = $userRepository->findOneBy(['email' => "$data"]);

        $this
            ->addTemporaryCollection($user->getEducation(), $temporaryEducationCollection)
            ->addTemporaryCollection($user->getSpokenLanguage(), $temporaryLanguageCollection)
            ->addTemporaryCollection($user->getCareerSummaries(), $temporaryCareerCollection)
            ->addTemporaryCollection($user->getTechnicalExperiences(), $temporaryTechnicalExperienceCollection);

        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();

            $this
                ->removeFromCollection($temporaryEducationCollection, $user->getEducation(), $em)
                ->removeFromCollection($temporaryLanguageCollection, $user->getSpokenLanguage(), $em)
                ->removeFromCollection($temporaryCareerCollection, $user->getCareerSummaries(), $em)
                ->removeFromCollection($temporaryTechnicalExperienceCollection, $user->getTechnicalExperiences(), $em);

            $em->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user_registration/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted("ROLE_MANAGER")
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $temporaryEducationCollection = new ArrayCollection();
        $temporaryLanguageCollection = new ArrayCollection();
        $temporaryCareerCollection = new ArrayCollection();
        $temporaryTechnicalExperienceCollection = new ArrayCollection();

        $this
            ->addTemporaryCollection($user->getEducation(), $temporaryEducationCollection)
            ->addTemporaryCollection($user->getSpokenLanguage(), $temporaryLanguageCollection)
            ->addTemporaryCollection($user->getCareerSummaries(), $temporaryCareerCollection)
            ->addTemporaryCollection($user->getTechnicalExperiences(), $temporaryTechnicalExperienceCollection);

        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $this
                ->removeFromCollection($temporaryEducationCollection, $user->getEducation(), $em)
                ->removeFromCollection($temporaryLanguageCollection, $user->getSpokenLanguage(), $em)
                ->removeFromCollection($temporaryCareerCollection, $user->getCareerSummaries(), $em)
                ->removeFromCollection($temporaryTechnicalExperienceCollection, $user->getTechnicalExperiences(), $em);

            $em->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user_registration/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
