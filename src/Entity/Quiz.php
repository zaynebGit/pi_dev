<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La matière ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La matière ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $Matiere = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La question 1 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La question 1 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $quest1 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La question 2 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La question 2 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $quest2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La question 3 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La question 3 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $quest3 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse correcte pour la question 1 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse correcte pour la question 1 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $correctAnswer1 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse correcte pour la question 2 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse correcte pour la question 2 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $correctAnswer2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse correcte pour la question 3 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse correcte pour la question 3 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $correctAnswer3 = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Choice(choices: ["easy", "medium", "hard"], message: "La difficulté doit être 'easy', 'medium' ou 'hard'.")]
    private ?string $diff = null;

    #[ORM\OneToMany(targetEntity: RespQuiz::class, mappedBy: 'quiz', orphanRemoval: true)]
    private Collection $respQuizzes;

    public function __construct()
    {
        $this->respQuizzes = new ArrayCollection();
    }

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatiere(): ?string
    {
        return $this->Matiere;
    }

    public function setMatiere(string $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    public function getQuest1(): ?string
    {
        return $this->quest1;
    }

    public function setQuest1(string $quest1): static
    {
        $this->quest1 = $quest1;

        return $this;
    }

    public function getQuest2(): ?string
    {
        return $this->quest2;
    }

    public function setQuest2(string $quest2): static
    {
        $this->quest2 = $quest2;

        return $this;
    }

    public function getQuest3(): ?string
    {
        return $this->quest3;
    }

    public function setQuest3(string $quest3): static
    {
        $this->quest3 = $quest3;

        return $this;
    }

    public function getCorrectAnswer1(): ?string
    {
        return $this->correctAnswer1;
    }

    public function setCorrectAnswer1(string $correctAnswer1): static
    {
        $this->correctAnswer1 = $correctAnswer1;

        return $this;
    }

    public function getCorrectAnswer2(): ?string
    {
        return $this->correctAnswer2;
    }

    public function setCorrectAnswer2(string $correctAnswer2): static
    {
        $this->correctAnswer2 = $correctAnswer2;

        return $this;
    }

    public function getCorrectAnswer3(): ?string
    {
        return $this->correctAnswer3;
    }

    public function setCorrectAnswer3(string $correctAnswer3): static
    {
        $this->correctAnswer3 = $correctAnswer3;

        return $this;
    }

    public function getDiff(): ?string
    {
        return $this->diff;
    }

    public function setDiff(?string $diff): static
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * @return Collection<int, RespQuiz>
     */
    public function getRespQuizzes(): Collection
    {
        return $this->respQuizzes;
    }

    public function addRespQuiz(RespQuiz $respQuiz): static
    {
        if (!$this->respQuizzes->contains($respQuiz)) {
            $this->respQuizzes->add($respQuiz);
            $respQuiz->setQuiz($this);
        }

        return $this;
    }

    public function removeRespQuiz(RespQuiz $respQuiz): static
    {
        if ($this->respQuizzes->removeElement($respQuiz)) {
            // set the owning side to null (unless already changed)
            if ($respQuiz->getQuiz() === $this) {
                $respQuiz->setQuiz(null);
            }
        }

        return $this;
    }
}