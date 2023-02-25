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
    normalizationContext: ['groups' => ['spot']],
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
    private ?bool $isPublic = null;

    #[ORM\OneToMany(mappedBy: 'signalSpot', targetEntity: Target::class)]
    #[Groups(["spot"])]
    private Collection $targets;

    public function __construct()
    {
        $this->targets = new ArrayCollection();
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

    /**
     * @return Collection<int, Target>
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets->add($target);
            $target->setSignalSpot($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getSignalSpot() === $this) {
                $target->setSignalSpot(null);
            }
        }

        return $this;
    }
}
