<?php

namespace App\Entity;

use App\Repository\RespQuizRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RespQuizRepository::class)]
class RespQuiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'respQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse à la question 1 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse à la question 1 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $userAnswer1 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse à la question 2 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse à la question 2 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $userAnswer2 = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La réponse à la question 3 ne peut pas être vide.")]
    #[Assert\Length(max: 255, maxMessage: "La réponse à la question 3 ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $userAnswer3 = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $submittedAt = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: "La note doit être comprise entre {{ min }} et {{ max }}."
    )]
    private ?int $rate = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $score = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getUserAnswer1(): ?string
    {
        return $this->userAnswer1;
    }

    public function setUserAnswer1(string $userAnswer1): static
    {
        $this->userAnswer1 = $userAnswer1;

        return $this;
    }

    public function getUserAnswer2(): ?string
    {
        return $this->userAnswer2;
    }

    public function setUserAnswer2(string $userAnswer2): static
    {
        $this->userAnswer2 = $userAnswer2;

        return $this;
    }

    public function getUserAnswer3(): ?string
    {
        return $this->userAnswer3;
    }

    public function setUserAnswer3(string $userAnswer3): static
    {
        $this->userAnswer3 = $userAnswer3;

        return $this;
    }

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submittedAt;
    }

    public function setSubmittedAt(\DateTimeInterface $submittedAt): static
    {
        $this->submittedAt = $submittedAt;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): static
    {
        $this->score = $score;

        return $this;
    }
}