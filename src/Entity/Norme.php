<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Norme
 *
 * @ORM\Table(name="norme")
 * @ORM\Entity
 */
class Norme
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=50, nullable=false)
     */
    private $label;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comments", type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @var string|null
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=NormesAutorisees::class, mappedBy="normes")
     */
    private $normesAutorisees;

    public function __construct()
    {
        $this->normesAutorisees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @return Collection<int, NormesAutorisees>
     */
    public function getNormesAutorisees(): Collection
    {
        return $this->normesAutorisees;
    }

    public function addNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if (!$this->normesAutorisees->contains($normesAutorisee)) {
            $this->normesAutorisees[] = $normesAutorisee;
            $normesAutorisee->setNormes($this);
        }

        return $this;
    }

    public function removeNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if ($this->normesAutorisees->removeElement($normesAutorisee)) {
            // set the owning side to null (unless already changed)
            if ($normesAutorisee->getNormes() === $this) {
                $normesAutorisee->setNormes(null);
            }
        }

        return $this;
    }
}
