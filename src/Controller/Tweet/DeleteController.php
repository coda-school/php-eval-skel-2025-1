<?php

namespace App\Controller\Tweet;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeleteController extends AbstractController
{
    #[Route('/tweet/delete', name: 'app_tweet_delete')]
    public function index(): Response
    {
        return $this->render('tweet/delete/index.html.twig', [
            'controller_name' => 'Tweet/DeleteController',
        ]);
    }
}
