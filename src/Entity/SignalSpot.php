<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SignalSpotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SignalSpotRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['spot', 'get']],
)]
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
    #[Groups(["spot"])]
    private ?float $entry = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["spot"])]
    private ?float $stop = null;

    #[ORM\ManyToOne(inversedBy: 'signalSpots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["spot"])]
    private ?Coin $coin = null;

    #[ORM\Column]
    #[Groups(["spot"])]
    private ?bool $isPublic = true;

    #[ORM\Column]
    #[Groups(["spot"])]
    private ?bool $isActive = true;

    #[ORM\Column(nullable: true)]
    #[Groups(["spot"])]
    private ?float $target1 = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["spot"])]
    private ?float $target2 = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["spot"])]
    private ?float $target3 = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["spot"])]
    private ?float $target4 = null;

    public function __construct()
    {
    }

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

    public function getCoin(): ?Coin
    {
        return $this->coin;
    }

    public function setCoin(?Coin $coin): self
    {
        $this->coin = $coin;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getTarget1(): ?float
    {
        return $this->target1;
    }

    public function setTarget1(?float $target1): self
    {
        $this->target1 = $target1;

        return $this;
    }

    public function getTarget2(): ?float
    {
        return $this->target2;
    }

    public function setTarget2(?float $target2): self
    {
        $this->target2 = $target2;

        return $this;
    }

    public function getTarget3(): ?float
    {
        return $this->target3;
    }

    public function setTarget3(?float $target3): self
    {
        $this->target3 = $target3;

        return $this;
    }

    public function getTarget4(): ?float
    {
        return $this->target4;
    }

    public function setTarget4(?float $target4): self
    {
        $this->target4 = $target4;

        return $this;
    }
}
