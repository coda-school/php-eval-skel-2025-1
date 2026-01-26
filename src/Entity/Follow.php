<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowRepository::class)]
class Follow extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $follower_id = null;

    #[ORM\Column]
    private ?int $following_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowerId(): ?int
    {
        return $this->follower_id;
    }

    public function setFollowerId(int $follower_id): static
    {
        $this->follower_id = $follower_id;

        return $this;
    }

    public function getFollowingId(): ?int
    {
        return $this->following_id;
    }

    public function setFollowingId(int $following_id): static
    {
        $this->following_id = $following_id;

        return $this;
    }
}
