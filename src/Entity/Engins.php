<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Engins
 *
 * @ORM\Table(name="engins", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"}), @ORM\Index(name="id_norme", columns={"id_norme"})})
 * @ORM\Entity
 */
class Engins
{
    /**
     * @var int
     *
     * @ORM\Column(name="id",                   type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="normes", type="string", length=255, nullable=true)
     */
    private $normes;

    /**
     * @var string|null
     *
     * @ORM\Column(name="categories", type="string", length=255, nullable=true)
     */
    private $categories;

    /**
     * @var string|null
     *
     * @ORM\Column(name="types", type="string", length=255, nullable=true)
     */
    private $types;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptions", type="string", length=255, nullable=true)
     */
    private $descriptions;

    /**
     * @var string|null
     *
     * @ORM\Column(name="carac_mini", type="string", length=255, nullable=true)
     */
    private $caracMini;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaires", type="text", length=65535, nullable=true)
     */
    private $commentaires;

    /**
     * @var \Norme
     *
     * @ORM\ManyToOne(targetEntity="Norme")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_norme",     referencedColumnName="id")
     * })
     */
    private $idNorme;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_categorie",     referencedColumnName="id")
     * })
     */
    private $idCategorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNormes(): ?string
    {
        return $this->normes;
    }

    public function setNormes(?string $normes): self
    {
        $this->normes = $normes;

        return $this;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(?string $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTypes(): ?string
    {
        return $this->types;
    }

    public function setTypes(?string $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(?string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getCaracMini(): ?string
    {
        return $this->caracMini;
    }

    public function setCaracMini(?string $caracMini): self
    {
        $this->caracMini = $caracMini;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): self
    {
        $this->commentaires = $commentaires;

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

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }


}
