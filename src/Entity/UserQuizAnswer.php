<?php

namespace App\Entity;

use App\Repository\UserQuizAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserQuizAnswerRepository::class)
 */
class UserQuizAnswer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Questions::class, inversedBy="userQuizAnswers")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Answers::class, inversedBy="userQuizAnswers")
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity=UserQuizResult::class, inversedBy="userQuizAnswers")
     */
    private $userQuizResult;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="userQuizAnswers")
     */
    private $candidat;

    /**
     * @ORM\Column(type="integer")
     */
    private $pts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $quesstion): self
    {
        $this->question = $quesstion;

        return $this;
    }

    public function getAnswer(): ?Answers
    {
        return $this->answer;
    }

    public function setAnswer(?Answers $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getUserQuizResult(): ?UserQuizResult
    {
        return $this->userQuizResult;
    }

    public function setUserQuizResult(?UserQuizResult $userQuizResult): self
    {
        $this->userQuizResult = $userQuizResult;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

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
}
