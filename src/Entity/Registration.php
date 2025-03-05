<?php
// src/Entity/Registration.php
namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "The name is required.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The name cannot exceed 255 characters."
    )]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "The email is required.")]
    #[Assert\Email(message: "The email '{{ value }}' is not a valid email address.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The email cannot exceed 255 characters."
    )]
    private $email;

    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "The event is required.")]
    private $event;

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("The name cannot be empty.");
        }
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }
        $this->email = $email;
        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        if ($event === null) {
            throw new \InvalidArgumentException("The event cannot be null.");
        }
        $this->event = $event;
        return $this;
    }
}
