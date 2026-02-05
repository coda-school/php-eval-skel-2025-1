<?php

namespace App\Service;


use App\Repository\ViewRepository;

readonly class ViewService
{
    public function __construct (
        private ViewRepository $viewRepository,
    )
    {
    }

    public function countViewsByTweetId(int $tweetId): int
    {
        return $this->viewRepository->countViewsByTweetId($tweetId);
    }

    public function countViewsOfTweetsByUserId(int $userId): int
    {
        return $this->viewRepository->countViewsOfTweetsByUserId($userId);
    }

    public function addView(int $tweetId, ?\App\Entity\User $user, \Doctrine\ORM\EntityManagerInterface $entityManager): void
    {
        $view = new \App\Entity\View();
        $view->setTweetId($tweetId);
        if ($user) {
            $view->setUserId($user->getId());
            $view->setCreatedBy($user);
        }
        $view->setCreatedDate(new \DateTime());
        $entityManager->persist($view);
        $entityManager->flush();
    }
}
