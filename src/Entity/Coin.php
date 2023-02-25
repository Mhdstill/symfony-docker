<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CoinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CoinRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['coin']],
)]
class Coin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["coin", "spot", "futur"])]
    private ?string $name = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(["coin", "spot", "futur"])]
    private ?MediaObject $image = null;

    #[ORM\OneToMany(mappedBy: 'coin', targetEntity: SignalFutur::class, orphanRemoval: true)]
    private Collection $signalFuturs;

    #[ORM\OneToMany(mappedBy: 'coin', targetEntity: SignalSpot::class, orphanRemoval: true)]
    private Collection $signalSpots;

    public function __construct()
    {
        $this->signalFuturs = new ArrayCollection();
        $this->signalSpots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, SignalFutur>
     */
    public function getSignalFuturs(): Collection
    {
        return $this->signalFuturs;
    }

    public function addSignalFutur(SignalFutur $signalFutur): self
    {
        if (!$this->signalFuturs->contains($signalFutur)) {
            $this->signalFuturs->add($signalFutur);
            $signalFutur->setCoin($this);
        }

        return $this;
    }

    public function removeSignalFutur(SignalFutur $signalFutur): self
    {
        if ($this->signalFuturs->removeElement($signalFutur)) {
            // set the owning side to null (unless already changed)
            if ($signalFutur->getCoin() === $this) {
                $signalFutur->setCoin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SignalSpot>
     */
    public function getSignalSpots(): Collection
    {
        return $this->signalSpots;
    }

    public function addSignalSpot(SignalSpot $signalSpot): self
    {
        if (!$this->signalSpots->contains($signalSpot)) {
            $this->signalSpots->add($signalSpot);
            $signalSpot->setCoin($this);
        }

        return $this;
    }

    public function removeSignalSpot(SignalSpot $signalSpot): self
    {
        if ($this->signalSpots->removeElement($signalSpot)) {
            // set the owning side to null (unless already changed)
            if ($signalSpot->getCoin() === $this) {
                $signalSpot->setCoin(null);
            }
        }

        return $this;
    }
}
