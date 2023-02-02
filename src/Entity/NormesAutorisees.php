<?php

namespace App\Entity;

use App\Repository\NormesAutoriseesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NormesAutoriseesRepository::class)
 */
class NormesAutorisees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class, inversedBy="normesAutorisees")
     */
    private $society;

    /**
     * @ORM\ManyToOne(targetEntity=Norme::class, inversedBy="normesAutorisees")
     */
    private $normes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getNormes(): ?Norme
    {
        return $this->normes;
    }

    public function setNormes(?Norme $normes): self
    {
        $this->normes = $normes;

        return $this;
    }

    public function __toString()
    {
        return $this->getNormes()->getLabel();
    }
}
