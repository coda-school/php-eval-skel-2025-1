<?php

namespace App\Controller\Comment;

use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteController extends AbstractController
{
    public function __construct(
        private readonly CommentService $commentService,
    ) {
    }

    #[Route('/comment/delete/{id}', name: 'app_comment_delete', methods: ['POST', 'GET'])]
    public function index(int $id): Response
    {
        $comment = $this->commentService->findById($id);

        if (!$comment) {
            throw $this->createNotFoundException('Le commentaire n\'existe pas.');
        }

        // Vérifier si l'utilisateur est l'auteur du commentaire
        if ($comment->getCreatedBy() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer ce commentaire.');
        }

        $tweetId = $comment->getTweetId();
        $this->commentService->delete($comment);

        return $this->redirectToRoute('app_tweet_show', ['id' => $tweetId]);
    }
}
