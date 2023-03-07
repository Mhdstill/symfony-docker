<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use App\Repository\SignalFuturRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SignalFuturRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['futur', 'get']],
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
class SignalFutur
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["futur"])]
    private ?float $entry = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["futur"])]
    private ?float $stop = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["futur"])]
    private ?int $leverage = null;

    #[ORM\Column]
    #[Groups(["futur"])]
    private ?bool $short = null;

    #[ORM\ManyToOne(inversedBy: 'signalFuturs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["futur"])]
    private ?Coin $coin = null;

    #[ORM\Column]
    #[Groups(["futur"])]
    private ?bool $isPublic = true;

    #[ORM\Column]
    private ?bool $isActive = true;

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

    public function setStop(?float $stop): self
    {
        $this->stop = $stop;

        return $this;
    }

    public function getLeverage(): ?int
    {
        return $this->leverage;
    }

    public function setLeverage(?int $leverage): self
    {
        $this->leverage = $leverage;

        return $this;
    }

    public function isShort(): ?bool
    {
        return $this->short;
    }

    public function setShort(bool $short): self
    {
        $this->short = $short;

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

}
