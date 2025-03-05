<?php
// src/Entity/Event.php
namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "The event name is required.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The event name cannot exceed 255 characters."
    )]
    private $name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: "The event description is required.")]
    #[Assert\Length(
        min: 10,
        minMessage: "The event description must be at least 10 characters long."
    )]
    private $description;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message: "The event date is required.")]
    #[Assert\Type("\DateTimeInterface", message: "Invalid date format.")]
    #[Assert\GreaterThan("today", message: "The event date must be in the future.")]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "The event location is required.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The location name cannot exceed 255 characters."
    )]
    private $location;

    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'event')]
    private $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

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
            throw new \InvalidArgumentException("The event name cannot be empty.");
        }
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        if (strlen($description) < 10) {
            throw new \InvalidArgumentException("The event description must be at least 10 characters long.");
        }
        $this->description = $description;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        if ($date < new \DateTime()) {
            throw new \InvalidArgumentException("The event date must be in the future.");
        }
        $this->date = $date;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        if (empty($location)) {
            throw new \InvalidArgumentException("The event location cannot be empty.");
        }
        $this->location = $location;
        return $this;
    }

    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }
}
