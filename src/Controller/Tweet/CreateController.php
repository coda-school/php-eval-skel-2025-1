<?php

namespace App\Controller\Tweet;

use App\Entity\Tweet;
use App\Form\TweetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class CreateController extends AbstractController
{
    #[Route('/tweet/create', name: 'app_tweet_create', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tweet = new Tweet();
        $tweet->setCreatedBy($this->getUser());
        $tweet->setCreatedDate(new \DateTime());
        $tweet->setUid(Uuid::v4());

        $form = $this->createForm(TweetType::class, $tweet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tweet);
            $entityManager->flush();

            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('tweet/create/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
