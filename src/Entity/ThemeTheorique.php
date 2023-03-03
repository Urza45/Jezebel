<?php

namespace App\Entity;

use App\Repository\ThemeTheoriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemeTheoriqueRepository::class)
 */
class ThemeTheorique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $intitule;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $pts;

    /**
     * @ORM\ManyToOne(targetEntity=Norme::class, inversedBy="themeTheoriques")
     */
    private $normeId;

    /**
     * @ORM\OneToMany(targetEntity=SousTheme::class, mappedBy="themeTheorique")
     */
    private $sousThemes;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="themeTheoriques")
     */
    private $quiz;

    public function __construct()
    {
        $this->sousThemes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(?string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPts(): ?int
    {
        return $this->pts;
    }

    public function setPts(int $pts): self
    {
        $this->pts = $pts;

        return $this;
    }

    public function getNormeId(): ?Norme
    {
        return $this->normeId;
    }

    public function setNormeId(?Norme $normeId): self
    {
        $this->normeId = $normeId;

        return $this;
    }

    /**
     * @return Collection<int, SousTheme>
     */
    public function getSousThemes(): Collection
    {
        return $this->sousThemes;
    }

    public function addSousTheme(SousTheme $sousTheme): self
    {
        if (!$this->sousThemes->contains($sousTheme)) {
            $this->sousThemes[] = $sousTheme;
            $sousTheme->setThemeTheorique($this);
        }

        return $this;
    }

    public function removeSousTheme(SousTheme $sousTheme): self
    {
        if ($this->sousThemes->removeElement($sousTheme)) {
            // set the owning side to null (unless already changed)
            if ($sousTheme->getThemeTheorique() === $this) {
                $sousTheme->setThemeTheorique(null);
            }
        }

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }
}
