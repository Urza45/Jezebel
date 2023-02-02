<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dossier
 *
 * @ORM\Table(name="dossier", indexes={@ORM\Index(name="id_formateur", columns={"id_formateur"}), @ORM\Index(name="id_norme", columns={"id_norme"}), @ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="id_testeur", columns={"id_testeur"})})
 * @ORM\Entity
 */
class Dossier
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
     * @ORM\Column(name="num_facture", type="string", length=50, nullable=true)
     */
    private $numFacture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type = '';

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_intervention", type="string", length=255, nullable=false)
     */
    private $adresseIntervention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_dossier", type="string", length=50, nullable=true)
     */
    private $numDossier;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_intervention", type="string", length=255, nullable=false)
     */
    private $villeIntervention;

    /**
     * @var int
     *
     * @ORM\Column(name="cp_intervention", type="integer", nullable=false)
     */
    private $cpIntervention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaires", type="string", length=255, nullable=true)
     */
    private $commentaires;

    /**
     * @var int
     *
     * @ORM\Column(name="codeagence", type="integer", nullable=false, options={"default"="78"})
     */
    private $codeagence = 78;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_testeur", referencedColumnName="id")
     * })
     */
    private $idTesteur;

    /**
     * @var \Norme
     *
     * @ORM\ManyToOne(targetEntity="Norme")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_norme", referencedColumnName="id")
     * })
     */
    private $idNorme;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_formateur", referencedColumnName="id"),
     * })
     */
    private $idFormateur;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class, inversedBy="dossiers")
     */
    private $society;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFacture(): ?string
    {
        return $this->numFacture;
    }

    public function setNumFacture(string $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAdresseIntervention(): ?string
    {
        return $this->adresseIntervention;
    }

    public function setAdresseIntervention(string $adresseIntervention): self
    {
        $this->adresseIntervention = $adresseIntervention;

        return $this;
    }

    public function getNumDossier(): ?string
    {
        return $this->numDossier;
    }

    public function setNumDossier(?string $numDossier): self
    {
        $this->numDossier = $numDossier;

        return $this;
    }

    public function getVilleIntervention(): ?string
    {
        return $this->villeIntervention;
    }

    public function setVilleIntervention(string $villeIntervention): self
    {
        $this->villeIntervention = $villeIntervention;

        return $this;
    }

    public function getCpIntervention(): ?int
    {
        return $this->cpIntervention;
    }

    public function setCpIntervention(int $cpIntervention): self
    {
        $this->cpIntervention = $cpIntervention;

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

    public function getCodeagence(): ?int
    {
        return $this->codeagence;
    }

    public function setCodeagence(int $codeagence): self
    {
        $this->codeagence = $codeagence;

        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getIdTesteur(): ?Users
    {
        return $this->idTesteur;
    }

    public function setIdTesteur(?Users $idTesteur): self
    {
        $this->idTesteur = $idTesteur;

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

    public function getIdFormateur(): ?Users
    {
        return $this->idFormateur;
    }

    public function setIdFormateur(?Users $idFormateur): self
    {
        $this->idFormateur = $idFormateur;

        return $this;
    }

    public function __toString()
    {
        return $this->numDossier;
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $Society): self
    {
        $this->society = $Society;

        return $this;
    }
}
