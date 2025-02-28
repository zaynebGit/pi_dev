<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Full Name is required')]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'Full Name must be at least {{ limit }} characters',
        maxMessage: 'Full Name cannot exceed {{ limit }} characters'
    )]
    private ?string $fullName = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'The email "{{ value }}" is not a valid email')]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Password is required')]
    #[Assert\Length(
        min: 8,
        max: 100,
        minMessage: 'Password must be at least {{ limit }} characters long',
        maxMessage: 'Password cannot exceed {{ limit }} characters'
    )]
    #[Assert\Regex(
        pattern: "/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])/",
        message: 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character'
    )]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'Role is required')]
    #[Assert\Choice(
        choices: ['ROLE_ADMIN', 'ROLE_CLIENT'],
        message: 'Invalid role selected'
    )]
    private ?string $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Required by UserInterface.
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * Required by UserInterface.
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    /**
     * Required by UserInterface.
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
