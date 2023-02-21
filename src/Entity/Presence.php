<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presence
 *
 * @ORM\Table(name="presence", indexes={@ORM\Index(name="idx_candidat", columns={"id_candidat"}), @ORM\Index(name="presence_FK", columns={"id_type_presence"}), @ORM\Index(name="idx_dossier", columns={"id_dossier"}), @ORM\Index(name="presence_FK_1", columns={"id_time"})})
 * @ORM\Entity
 */
class Presence
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
     * @var \DateTime
     *
     * @ORM\Column(name="pdate", type="date", nullable=false)
     */
    private $pdate;

    /**
     * @var array
     *
     * @ORM\Column(name="signature", type="json", nullable=false)
     */
    private $signature;

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
     * @var \TypePresence
     *
     * @ORM\ManyToOne(targetEntity="TypePresence")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_type_presence",    referencedColumnName="id")
     * })
     */
    private $idTypePresence;

    /**
     * @var \Dossier
     *
     * @ORM\ManyToOne(targetEntity="Dossier")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_dossier",     referencedColumnName="id")
     * })
     */
    private $idDossier;

    /**
     * @var \TimePeriode
     *
     * @ORM\ManyToOne(targetEntity="TimePeriode")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_time",            referencedColumnName="id")
     * })
     */
    private $idTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPdate(): ?\DateTimeInterface
    {
        return $this->pdate;
    }

    public function setPdate(\DateTimeInterface $pdate): self
    {
        $this->pdate = $pdate;

        return $this;
    }

    public function getSignature(): ?array
    {
        return $this->signature;
    }

    public function setSignature(array $signature): self
    {
        $this->signature = $signature;

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

    public function getIdTypePresence(): ?TypePresence
    {
        return $this->idTypePresence;
    }

    public function setIdTypePresence(?TypePresence $idTypePresence): self
    {
        $this->idTypePresence = $idTypePresence;

        return $this;
    }

    public function getIdDossier(): ?Dossier
    {
        return $this->idDossier;
    }

    public function setIdDossier(?Dossier $idDossier): self
    {
        $this->idDossier = $idDossier;

        return $this;
    }

    public function getIdTime(): ?TimePeriode
    {
        return $this->idTime;
    }

    public function setIdTime(?TimePeriode $idTime): self
    {
        $this->idTime = $idTime;

        return $this;
    }


}
