<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SignalSpotRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: SignalSpotRepository::class)]
#[ApiResource]
#[Post(
    security: "is_granted('ROLE_ADMIN')",
    securityMessage: 'Vous n\'avez pas les droits pour effectuer cette action.'
)]
#[Put(
    security: "is_granted('ROLE_ADMIN')",
    securityMessage: 'Vous n\'avez pas les droits pour effectuer cette action.'
)]
#[Delete(
    security: "is_granted('ROLE_ADMIN')",
    securityMessage: 'Vous n\'avez pas les droits pour effectuer cette action.'
)]
#[Get()]
#[GetCollection()]
#[ORM\HasLifecycleCallbacks]
class SignalSpot
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $entry = null;

    #[ORM\Column(nullable: true)]
    private ?float $stop = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntry(): ?float
    {
        return $this->entry;
    }

    public function setEntry(float $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getStop(): ?float
    {
        return $this->stop;
    }

    public function setStop(float $stop): self
    {
        $this->stop = $stop;

        return $this;
    }
}
