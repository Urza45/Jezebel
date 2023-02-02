<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie", indexes={@ORM\Index(name="id_norme", columns={"id_norme"})})
 * @ORM\Entity
 */
class Categorie
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
     * @var string
     *
     * @ORM\Column(name="label_court", type="string", length=50, nullable=false)
     */
    private $labelCourt;

    /**
     * @var \Norme
     *
     * @ORM\ManyToOne(targetEntity="Norme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_norme", referencedColumnName="id")
     * })
     */
    private $idNorme;

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

    public function getLabelCourt(): ?string
    {
        return $this->labelCourt;
    }

    public function setLabelCourt(string $labelCourt): self
    {
        $this->labelCourt = $labelCourt;

        return $this;
    }

    public function getIdNorme(): ?Norme
    {
        return $this->idNorme;
    }

    public function setIdNorme(?Norme $idNorme): self
    {
        $this->idNorme = $idNorme;

        return $this;
    }


}
