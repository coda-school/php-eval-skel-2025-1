<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TweetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TweetRepository::class)]
class Tweet extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 280)]
    private ?string $content = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $uid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUid(): ?Uuid
    {
        return $this->uid;
    }

    public function setUid(Uuid $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getAgo(): string
    {
        $now = new \DateTime();
        $diff = $now->diff($this->getCreatedDate());

        return match (true) {
            $diff->y > 0 => "Il y a " . $diff->y . " an" . ($diff->y > 1 ? "s" : ""),
            $diff->m > 0 => "Il y a " . $diff->m . " mois",
            $diff->d > 0 => "Il y a " . $diff->d . " j",
            $diff->h > 0 => "Il y a " . $diff->h . " h",
            $diff->i > 0 => "Il y a " . $diff->i . " min",
            default => "À l'instant",
        };
    }
}
