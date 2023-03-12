<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Norme::class, inversedBy="quizzes")
     */
    private $norme;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule;

    /**
     * @ORM\OneToMany(targetEntity=ThemeTheorique::class, mappedBy="quiz")
     */
    private $themeTheoriques;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class, inversedBy="quizzes")
     */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizResult::class, mappedBy="quiz")
     */
    private $userQuizResults;

    public function __construct()
    {
        $this->themeTheoriques = new ArrayCollection();
        $this->userQuizResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNorme(): ?Norme
    {
        return $this->norme;
    }

    public function setNorme(?Norme $norme): self
    {
        $this->norme = $norme;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function __toString()
    {
        return $this->getIntitule();
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
            $themeTheorique->setQuiz($this);
        }

        return $this;
    }

    public function removeThemeTheorique(ThemeTheorique $themeTheorique): self
    {
        if ($this->themeTheoriques->removeElement($themeTheorique)) {
            // set the owning side to null (unless already changed)
            if ($themeTheorique->getQuiz() === $this) {
                $themeTheorique->setQuiz(null);
            }
        }

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
            $userQuizResult->setQuiz($this);
        }

        return $this;
    }

    public function removeUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if ($this->userQuizResults->removeElement($userQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($userQuizResult->getQuiz() === $this) {
                $userQuizResult->setQuiz(null);
            }
        }

        return $this;
    }
}
