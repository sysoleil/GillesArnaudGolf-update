<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     * @Assert\Length(min="5",
     *                max="5000",
     *                minMessage="la description doit comporter plus de {{ limit }} carractères",
     *                maxMessage="la description ne doit pas comporter plus de {{ limit }} carractères")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\File(maxSize="250M")
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $alt;

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

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }
    /**
     * @Assert
     *     maxSize = "250M",
     *     maxSizeMessage="Max. video size: 250MB. "
     */

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
}
