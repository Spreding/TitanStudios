<?php

namespace App\Entity;

use App\Repository\LinksRealisationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinksRealisationRepository::class)
 */
class LinksRealisation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Realisations::class, inversedBy="linksRealisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameLink;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealisation(): ?Realisations
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisations $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getNameLink(): ?string
    {
        return $this->nameLink;
    }

    public function setNameLink(?string $nameLink): self
    {
        $this->nameLink = $nameLink;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
