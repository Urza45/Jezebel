<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoriechoisie
 *
 * @ORM\Table(name="categoriechoisie", indexes={@ORM\Index(name="id_candidat", columns={"id_candidat"}), @ORM\Index(name="id_category", columns={"id_category"})})
 * @ORM\Entity
 */
class Categoriechoisie
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
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id")
     * })
     */
    private $idCategory;

    /**
     * @var \Candidat
     *
     * @ORM\ManyToOne(targetEntity="Candidat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_candidat", referencedColumnName="id")
     * })
     */
    private $idCandidat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategory(): ?Categorie
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Categorie $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getIdCandidat(): ?Candidat
    {
        return $this->idCandidat;
    }

    public function setIdCandidat(?Candidat $idCandidat): self
    {
        $this->idCandidat = $idCandidat;

        return $this;
    }


}
