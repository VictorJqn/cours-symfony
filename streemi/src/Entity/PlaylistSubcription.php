<?php

namespace App\Entity;

use App\Repository\PlaylistSubcriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubcriptionRepository::class)]
class PlaylistSubcription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $subscribed_at = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Playlist $playlist = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'playlistSubscriptions')]
    private ?User $subscriber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscribedAt(): ?\DateTimeImmutable
    {
        return $this->subscribed_at;
    }

    public function setSubscribedAt(\DateTimeImmutable $subscribed_at): static
    {
        $this->subscribed_at = $subscribed_at;

        return $this;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): static
    {
        $this->subscriber = $subscriber;

        return $this;
    }
}
