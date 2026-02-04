<?php

namespace App\Controller\Comment;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Service\CommentService;
use App\Service\TweetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateController extends AbstractController
{
    public function __construct(
        private readonly CommentService $commentService,
        private readonly TweetService $tweetService,
    ) {
    }

    #[Route('/comment/create/{tweetId}', name: 'app_comment_create', methods: ['GET', 'POST'])]
    public function index(int $tweetId, Request $request): Response
    {
        $tweet = $this->tweetService->findById($tweetId);

        if (!$tweet) {
            throw $this->createNotFoundException('Le tweet n\'existe pas.');
        }

        $comment = new Comment();
        $comment->setTweetId($tweetId);
        $comment->setCreatedBy($this->getUser());
        $comment->setCreatedDate(new \DateTime());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->create($comment);

            return $this->redirectToRoute('app_tweet_show', ['id' => $tweetId]);
        }

        return $this->render('comment/create/index.html.twig', [
            'form' => $form->createView(),
            'tweet' => $tweet,
        ]);
    }
}
