<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidat
 *
 * @ORM\Table(name="candidat",                                      indexes={@ORM\Index(name="id_dossier", columns={"id_dossier"}), @ORM\Index(name="candidat_id_niveau_competence_IDX", columns={"id_niveau_competence"}), @ORM\Index(name="candidat_FK_3", columns={"formation_recue"}), @ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="candidat_id_status_IDX", columns={"id_status"}), @ORM\Index(name="candidat_FK_2", columns={"experience_production"})})
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 */
class Candidat
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
     * @var string
     *
     * @ORM\Column(name="nom_candidat", type="string", length=50, nullable=false)
     */
    private $nomCandidat;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_candidat", type="string", length=50, nullable=false)
     */
    private $prenomCandidat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duree_experience", type="integer", nullable=true)
     */
    private $dureeExperience;

    /**
     * @var int|null
     *
     * @ORM\Column(name="heure_formation", type="integer", nullable=true)
     */
    private $heureFormation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_theorique", type="date", nullable=true)
     */
    private $dateTheorique;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_pratique", type="date", nullable=true)
     */
    private $datePratique;

    /**
     * @var int|null
     *
     * @ORM\Column(name="note_formation", type="integer", nullable=true)
     */
    private $noteFormation;

    /**
     * @var \OuiNon
     *
     * @ORM\ManyToOne(targetEntity="OuiNon")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="experience_production", referencedColumnName="id")
     * })
     */
    private $experienceProduction;

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
     * @var \Status
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_status",     referencedColumnName="id")
     * })
     */
    private $idStatus;

    /**
     * @var \OuiNon
     *
     * @ORM\ManyToOne(targetEntity="OuiNon")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="formation_recue", referencedColumnName="id")
     * })
     */
    private $formationRecue;

    /**
     * @var \NiveauCompetence
     *
     * @ORM\ManyToOne(targetEntity="NiveauCompetence")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_niveau_competence",    referencedColumnName="id")
     * })
     */
    private $idNiveauCompetence;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_client",     referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class, inversedBy="candidats")
     */
    private $society;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCandidat(): ?string
    {
        return $this->nomCandidat;
    }

    public function setNomCandidat(string $nomCandidat): self
    {
        $this->nomCandidat = $nomCandidat;

        return $this;
    }

    public function getPrenomCandidat(): ?string
    {
        return $this->prenomCandidat;
    }

    public function setPrenomCandidat(string $prenomCandidat): self
    {
        $this->prenomCandidat = $prenomCandidat;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDureeExperience(): ?int
    {
        return $this->dureeExperience;
    }

    public function setDureeExperience(?int $dureeExperience): self
    {
        $this->dureeExperience = $dureeExperience;

        return $this;
    }

    public function getHeureFormation(): ?int
    {
        return $this->heureFormation;
    }

    public function setHeureFormation(?int $heureFormation): self
    {
        $this->heureFormation = $heureFormation;

        return $this;
    }

    public function getDateTheorique(): ?\DateTimeInterface
    {
        return $this->dateTheorique;
    }

    public function setDateTheorique(?\DateTimeInterface $dateTheorique): self
    {
        $this->dateTheorique = $dateTheorique;

        return $this;
    }

    public function getDatePratique(): ?\DateTimeInterface
    {
        return $this->datePratique;
    }

    public function setDatePratique(?\DateTimeInterface $datePratique): self
    {
        $this->datePratique = $datePratique;

        return $this;
    }

    public function getNoteFormation(): ?int
    {
        return $this->noteFormation;
    }

    public function setNoteFormation(?int $noteFormation): self
    {
        $this->noteFormation = $noteFormation;

        return $this;
    }

    public function getExperienceProduction(): ?OuiNon
    {
        return $this->experienceProduction;
    }

    public function setExperienceProduction(?OuiNon $experienceProduction): self
    {
        $this->experienceProduction = $experienceProduction;

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

    public function getIdStatus(): ?Status
    {
        return $this->idStatus;
    }

    public function setIdStatus(?Status $idStatus): self
    {
        $this->idStatus = $idStatus;

        return $this;
    }

    public function getFormationRecue(): ?OuiNon
    {
        return $this->formationRecue;
    }

    public function setFormationRecue(?OuiNon $formationRecue): self
    {
        $this->formationRecue = $formationRecue;

        return $this;
    }

    public function getIdNiveauCompetence(): ?NiveauCompetence
    {
        return $this->idNiveauCompetence;
    }

    public function setIdNiveauCompetence(?NiveauCompetence $idNiveauCompetence): self
    {
        $this->idNiveauCompetence = $idNiveauCompetence;

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

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }
}
