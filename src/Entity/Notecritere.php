<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notecritere
 *
 * @ORM\Table(name="notecritere", indexes={@ORM\Index(name="id_critere", columns={"id_critere"}), @ORM\Index(name="id_candidat", columns={"id_candidat"})})
 * @ORM\Entity
 */
class Notecritere
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
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     */
    private $idCategorie;

    /**
     * @var int|null
     *
     * @ORM\Column(name="note1", type="integer", nullable=true)
     */
    private $note1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="note2", type="integer", nullable=true)
     */
    private $note2;

    /**
     * @var \Candidat
     *
     * @ORM\ManyToOne(targetEntity="Candidat")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_candidat",     referencedColumnName="id")
     * })
     */
    private $idCandidat;

    /**
     * @var \Critere
     *
     * @ORM\ManyToOne(targetEntity="Critere")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_critere",     referencedColumnName="id")
     * })
     */
    private $idCritere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(int $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getNote1(): ?int
    {
        return $this->note1;
    }

    public function setNote1(?int $note1): self
    {
        $this->note1 = $note1;

        return $this;
    }

    public function getNote2(): ?int
    {
        return $this->note2;
    }

    public function setNote2(?int $note2): self
    {
        $this->note2 = $note2;

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

    public function getIdCritere(): ?Critere
    {
        return $this->idCritere;
    }

    public function setIdCritere(?Critere $idCritere): self
    {
        $this->idCritere = $idCritere;

        return $this;
    }


}
