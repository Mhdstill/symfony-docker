<?php

namespace App\Entity;

use App\Repository\TargetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: TargetRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['target']],
)]
class Target
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["futur", "spot", "target"])]
    private ?float $value = null;

    #[ORM\Column]
    #[Groups(["futur", "spot", "target"])]
    private ?float $percent = null;

    #[ORM\ManyToOne(inversedBy: 'targets')]
    private ?SignalFutur $signalFutur = null;

    #[ORM\ManyToOne(inversedBy: 'targets')]
    private ?SignalSpot $signalSpot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    public function getSignalFutur(): ?SignalFutur
    {
        return $this->signalFutur;
    }

    public function setSignalFutur(?SignalFutur $signalFutur): self
    {
        $this->signalFutur = $signalFutur;

        return $this;
    }

    public function getSignalSpot(): ?SignalSpot
    {
        return $this->signalSpot;
    }

    public function setSignalSpot(?SignalSpot $signalSpot): self
    {
        $this->signalSpot = $signalSpot;

        return $this;
    }
}
