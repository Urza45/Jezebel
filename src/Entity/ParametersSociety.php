<?php

namespace App\Entity;

use App\Repository\ParametersSocietyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParametersSocietyRepository::class)
 */
class ParametersSociety
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeDossier;

    /**
     * @ORM\Column(type="integer")
     */
    private $incCodeDossier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeFacture;

    /**
     * @ORM\Column(type="integer")
     */
    private $incCodeFacture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeConvention;

    /**
     * @ORM\Column(type="integer")
     */
    private $incCodeConvention;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeDevis;

    /**
     * @ORM\Column(type="integer")
     */
    private $incCodeDevis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeConvocation;

    /**
     * @ORM\Column(type="integer")
     */
    private $incCodeConvocation;

    /**
     * @ORM\OneToOne(targetEntity=Society::class, inversedBy="parametersSociety", cascade={"persist", "remove"})
     */
    private $idSociety;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeDossier(): ?string
    {
        return $this->codeDossier;
    }

    public function setCodeDossier(string $codeDossier): self
    {
        $this->codeDossier = $codeDossier;

        return $this;
    }

    public function getIncCodeDossier(): ?int
    {
        return $this->incCodeDossier;
    }

    public function setIncCodeDossier(int $incCodeDossier): self
    {
        $this->incCodeDossier = $incCodeDossier;

        return $this;
    }

    public function getCodeFacture(): ?string
    {
        return $this->codeFacture;
    }

    public function setCodeFacture(string $codeFacture): self
    {
        $this->codeFacture = $codeFacture;

        return $this;
    }

    public function getIncCodeFacture(): ?int
    {
        return $this->incCodeFacture;
    }

    public function setIncCodeFacture(int $incCodeFacture): self
    {
        $this->incCodeFacture = $incCodeFacture;

        return $this;
    }

    public function getCodeConvention(): ?string
    {
        return $this->codeConvention;
    }

    public function setCodeConvention(string $codeConvention): self
    {
        $this->codeConvention = $codeConvention;

        return $this;
    }

    public function getIncCodeConvention(): ?int
    {
        return $this->incCodeConvention;
    }

    public function setIncCodeConvention(int $incCodeConvention): self
    {
        $this->incCodeConvention = $incCodeConvention;

        return $this;
    }

    public function getCodeDevis(): ?string
    {
        return $this->codeDevis;
    }

    public function setCodeDevis(string $codeDevis): self
    {
        $this->codeDevis = $codeDevis;

        return $this;
    }

    public function getIncCodeDevis(): ?int
    {
        return $this->incCodeDevis;
    }

    public function setIncCodeDevis(int $incCodeDevis): self
    {
        $this->incCodeDevis = $incCodeDevis;

        return $this;
    }

    public function getCodeConvocation(): ?string
    {
        return $this->codeConvocation;
    }

    public function setCodeConvocation(string $codeConvocation): self
    {
        $this->codeConvocation = $codeConvocation;

        return $this;
    }

    public function getIncCodeConvocation(): ?int
    {
        return $this->incCodeConvocation;
    }

    public function setIncCodeConvocation(int $incCodeConvocation): self
    {
        $this->incCodeConvocation = $incCodeConvocation;

        return $this;
    }

    public function getIdSociety(): ?Society
    {
        return $this->idSociety;
    }

    public function setIdSociety(?Society $idSociety): self
    {
        $this->idSociety = $idSociety;

        return $this;
    }
}
