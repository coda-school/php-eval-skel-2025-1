<?php

namespace App\Controller\Comment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteController extends AbstractController
{
    #[Route('/comment/delete', name: 'app_comment_delete')]
    public function index(): Response
    {
        return $this->render('comment/delete/index.html.twig', [
            'controller_name' => 'Comment/DeleteController',
        ]);
    }
}
