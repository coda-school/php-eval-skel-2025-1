<?php

namespace App\Controller\Comment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateController extends AbstractController
{
    #[Route('/comment/create', name: 'app_comment_create')]
    public function index(): Response
    {
        return $this->render('comment/create/index.html.twig', [
            'controller_name' => 'Comment/CreateController',
        ]);
    }
}
