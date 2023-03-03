<?php

namespace App\Entity;

use App\Repository\UserQuizResultRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserQuizResultRepository::class)
 */
class UserQuizResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="userQuizResults")
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity=Norme::class, inversedBy="userQuizResults")
     */
    private $norme;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizAnswer::class, mappedBy="userQuizResult")
     */
    private $userQuizAnswers;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="userQuizResults")
     */
    private $quiz;

    public function __construct()
    {
        $this->userQuizAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidat(): ?candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
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

    /**
     * @return Collection<int, UserQuizAnswer>
     */
    public function getUserQuizAnswers(): Collection
    {
        return $this->userQuizAnswers;
    }

    public function addUserQuizAnswer(UserQuizAnswer $userQuizAnswer): self
    {
        if (!$this->userQuizAnswers->contains($userQuizAnswer)) {
            $this->userQuizAnswers[] = $userQuizAnswer;
            $userQuizAnswer->setUserQuizResult($this);
        }

        return $this;
    }

    public function removeUserQuizAnswer(UserQuizAnswer $userQuizAnswer): self
    {
        if ($this->userQuizAnswers->removeElement($userQuizAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuizAnswer->getUserQuizResult() === $this) {
                $userQuizAnswer->setUserQuizResult(null);
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
