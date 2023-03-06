<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionsRepository::class)
 */
class Questions
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $pts;

    /**
     * @ORM\ManyToOne(targetEntity=SousTheme::class, inversedBy="questions")
     */
    private $sousTheme;

    /**
     * @ORM\OneToMany(targetEntity=Answers::class, mappedBy="question")
     */
    private $answers;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre;

    /**
     * @ORM\OneToMany(targetEntity=UserQuizAnswer::class, mappedBy="question")
     */
    private $userQuizAnswers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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

    public function getSousTheme(): ?SousTheme
    {
        return $this->sousTheme;
    }

    public function setSousTheme(?SousTheme $sousTheme): self
    {
        $this->sousTheme = $sousTheme;

        return $this;
    }

    /**
     * @return Collection<int, Answers>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answers $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answers $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

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
            $userQuizAnswer->setQuesstion($this);
        }

        return $this;
    }

    public function removeUserQuizAnswer(UserQuizAnswer $userQuizAnswer): self
    {
        if ($this->userQuizAnswers->removeElement($userQuizAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userQuizAnswer->getQuesstion() === $this) {
                $userQuizAnswer->setQuesstion(null);
            }
        }

        return $this;
    }
}
