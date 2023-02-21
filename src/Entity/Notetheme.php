<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notetheme
 *
 * @ORM\Table(name="notetheme", indexes={@ORM\Index(name="id_candidat", columns={"id_candidat"}), @ORM\Index(name="id_theme", columns={"id_theme"})})
 * @ORM\Entity
 */
class Notetheme
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
     * @ORM\Column(name="note1", type="integer", nullable=false)
     */
    private $note1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="note2", type="integer", nullable=true)
     */
    private $note2;

    /**
     * @var \Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_theme",     referencedColumnName="id")
     * })
     */
    private $idTheme;

    /**
     * @var \Candidat
     *
     * @ORM\ManyToOne(targetEntity="Candidat")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_candidat",     referencedColumnName="id")
     * })
     */
    private $idCandidat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote1(): ?int
    {
        return $this->note1;
    }

    public function setNote1(int $note1): self
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

    public function getIdTheme(): ?Theme
    {
        return $this->idTheme;
    }

    public function setIdTheme(?Theme $idTheme): self
    {
        $this->idTheme = $idTheme;

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
