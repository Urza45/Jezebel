<?php

namespace App\Entity;

use App\Repository\AnswersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswersRepository::class)
 */
class Answers
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
    private $bonneReponse;

    /**
     * @ORM\ManyToOne(targetEntity=Questions::class, inversedBy="answers")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizAnswer::class, mappedBy="answer")
     */
    private $userQuizAnswers;

    public function __construct()
    {
        $this->userQuizAnswers = new ArrayCollection();
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

    public function getBonneReponse(): ?string
    {
        return $this->bonneReponse;
    }

    public function setBonneReponse(?string $bonneReponse): self
    {
        $this->bonneReponse = $bonneReponse;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

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
            $userQuizAnswer->setAnswer($this);
        }

        return $this;
    }

    public function removeUserQuizAnswer(UserQuizAnswer $userQuizAnswer): self
    {
        if ($this->userQuizAnswers->removeElement($userQuizAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuizAnswer->getAnswer() === $this) {
                $userQuizAnswer->setAnswer(null);
            }
        }

        return $this;
    }
}
