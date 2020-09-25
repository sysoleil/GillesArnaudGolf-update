<?php

namespace App\Entity;

use App\Repository\UserTicketBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserTicketBookRepository::class)
 */
class UserTicketBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datePurchase;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userTicketBook")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=TicketBook::class, mappedBy="userTicketBook")
     */
    private $ticketBook;

    public function __construct()
    {
        $this->ticketBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePurchase(): ?\DateTimeInterface
    {
        return $this->datePurchase;
    }

    public function setDatePurchase(?\DateTimeInterface $datePurchase): self
    {
        $this->datePurchase = $datePurchase;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|TicketBook[]
     */
    public function getTicketBook(): Collection
    {
        return $this->ticketBook;
    }

    public function addTicketBook(TicketBook $ticketBook): self
    {
        if (!$this->ticketBook->contains($ticketBook)) {
            $this->ticketBook[] = $ticketBook;
            $ticketBook->setUserTicketBook($this);
        }

        return $this;
    }

    public function removeTicketBook(TicketBook $ticketBook): self
    {
        if ($this->ticketBook->contains($ticketBook)) {
            $this->ticketBook->removeElement($ticketBook);
            // set the owning side to null (unless already changed)
            if ($ticketBook->getUserTicketBook() === $this) {
                $ticketBook->setUserTicketBook(null);
            }
        }

        return $this;
    }
}
