<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Norme
 *
 * @ORM\Table(name="norme")
 * @ORM\Entity
 */
class Norme
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
     * @ORM\OneToMany(targetEntity=NormesAutorisees::class, mappedBy="normes")
     */
    private $normesAutorisees;

    /**
     * @ORM\OneToMany(targetEntity=ThemeTheorique::class, mappedBy="normeId")
     */
    private $themeTheoriques;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizResult::class, mappedBy="norme")
     */
    private $userQuizResults;

    /**
     * @ORM\OneToMany(targetEntity=Quiz::class, mappedBy="norme")
     */
    private $quizzes;

    public function __construct()
    {
        $this->normesAutorisees = new ArrayCollection();
        $this->themeTheoriques = new ArrayCollection();
        $this->userQuizResults = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
    }

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

    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @return Collection<int, NormesAutorisees>
     */
    public function getNormesAutorisees(): Collection
    {
        return $this->normesAutorisees;
    }

    public function addNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if (!$this->normesAutorisees->contains($normesAutorisee)) {
            $this->normesAutorisees[] = $normesAutorisee;
            $normesAutorisee->setNormes($this);
        }

        return $this;
    }

    public function removeNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if ($this->normesAutorisees->removeElement($normesAutorisee)) {
            // set the owning side to null (unless already changed)
            if ($normesAutorisee->getNormes() === $this) {
                $normesAutorisee->setNormes(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ThemeTheorique>
     */
    public function getThemeTheoriques(): Collection
    {
        return $this->themeTheoriques;
    }

    public function addThemeTheorique(ThemeTheorique $themeTheorique): self
    {
        if (!$this->themeTheoriques->contains($themeTheorique)) {
            $this->themeTheoriques[] = $themeTheorique;
            $themeTheorique->setNormeId($this);
        }

        return $this;
    }

    public function removeThemeTheorique(ThemeTheorique $themeTheorique): self
    {
        if ($this->themeTheoriques->removeElement($themeTheorique)) {
            // set the owning side to null (unless already changed)
            if ($themeTheorique->getNormeId() === $this) {
                $themeTheorique->setNormeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserQuizResult>
     */
    public function getUserQuizResults(): Collection
    {
        return $this->userQuizResults;
    }

    public function addUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if (!$this->userQuizResults->contains($userQuizResult)) {
            $this->userQuizResults[] = $userQuizResult;
            $userQuizResult->setNorme($this);
        }

        return $this;
    }

    public function removeUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if ($this->userQuizResults->removeElement($userQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($userQuizResult->getNorme() === $this) {
                $userQuizResult->setNorme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setNorme($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getNorme() === $this) {
                $quiz->setNorme(null);
            }
        }

        return $this;
    }
}
