<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
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


    /**
     * Require ROLE_ADMIN for only this controller method.
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
        $data = $this->getUser()->getUsername();
        $user = $userRepository->findOneBy(['email' => "$data"]);

        if ($user === null) {
            throw new Exception('User is not found');
        }

        function addTemporaryCollection(Collection $collection, $temporaryCollection)
        {
            foreach ($collection as $element) {
                $temporaryCollection->add($element);
            }
        }

        function removeFromCollection($temporaryCollection, $collection, EntityManager $em) {

            foreach ($temporaryCollection as $temporaryElement) {
                if ($collection->contains($temporaryElement) === false) {
                    $em->remove($temporaryElement);
                }
            }
        }

        $temporaryEducationCollection = new ArrayCollection();
        addTemporaryCollection($user->getEducation(), $temporaryEducationCollection);

        $temporaryLanguageCollection = new ArrayCollection();
        addTemporaryCollection($user->getSpokenLanguage(), $temporaryLanguageCollection);

        $temporaryCareerCollection = new ArrayCollection();
        addTemporaryCollection($user->getCareerSummaries(), $temporaryCareerCollection);

        $temporaryTechnicalExperienceCollection = new ArrayCollection();
        addTemporaryCollection($user->getTechnicalExperiences(), $temporaryTechnicalExperienceCollection);

        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);


        //получим id category

        //найдём по id category все skills

        //выведем их в choices

        if ($form->isSubmitted()) {

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();

            removeFromCollection($temporaryEducationCollection, $user->getEducation(), $em);
            removeFromCollection($temporaryLanguageCollection, $user->getSpokenLanguage(), $em);
            removeFromCollection($temporaryCareerCollection, $user->getCareerSummaries(), $em);
            removeFromCollection($temporaryTechnicalExperienceCollection, $user->getTechnicalExperiences(), $em);

            $em->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user_registration/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
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
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
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
