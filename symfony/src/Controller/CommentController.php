<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @return Response
     * @Route ("/comments/{id<\d+>}/vote/{direction<up|down>}", name="comment_page", methods="POST")
     */
    public function commentVolte($id, $direction):Response
    {
        if ($direction ==='up') {
            $currentVoteCount = rand(7, 100);
        } else {
            $currentVoteCount = rand(0, 5);
        }

        dump($currentVoteCount, $direction);
        return $this->json(['votes' => $currentVoteCount]);
    }
}