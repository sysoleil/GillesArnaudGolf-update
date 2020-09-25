<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min="5",
     *                max="150",
     *                minMessage="le titre doit avoir plus de {{ limit }} carractères",
     *                maxMessage="le titre ne doit pas comporter plus de {{ limit }} carractères")
     *
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $minPerson;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxPerson;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceCe;

    /**
     * @ORM\Column(type="float")
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ticket;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity=CourseStyle::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courseStyle;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="course")
     */
    private $calendars;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
    }


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
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMinPerson(): ?int
    {
        return $this->minPerson;
    }

    public function setMinPerson(int $minPerson): self
    {
        $this->minPerson = $minPerson;

        return $this;
    }

    public function getMaxPerson(): ?int
    {
        return $this->maxPerson;
    }

    public function setMaxPerson(int $maxPerson): self
    {
        $this->maxPerson = $maxPerson;

        return $this;
    }

    public function getPriceCe(): ?float
    {
        return $this->priceCe;
    }

    public function setPriceCe(?float $priceCe): self
    {
        $this->priceCe = $priceCe;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTicket(): ?bool
    {
        return $this->ticket;
    }

    public function setTicket(bool $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getCourseStyle(): ?CourseStyle
    {
        return $this->courseStyle;
    }

    public function setCourseStyle(?CourseStyle $courseStyle): self
    {
        $this->courseStyle = $courseStyle;

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars[] = $calendar;
            $calendar->setCourse($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->contains($calendar)) {
            $this->calendars->removeElement($calendar);
            // set the owning side to null (unless already changed)
            if ($calendar->getCourse() === $this) {
                $calendar->setCourse(null);
            }
        }

        return $this;
    }


}
