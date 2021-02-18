<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adoptions
 *
 * @ORM\Table(name="adoptions", indexes={@ORM\Index(name="pet_id", columns={"pet_id"}), @ORM\Index(name="petlover_id", columns={"petlover_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\AdoptionsRepository")
 */
class Adoptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="petlover_id", referencedColumnName="id")
     * })
     */
    private $petlover;

    /**
     * @var \App\Entity\Pets
     *
     * @ORM\ManyToOne(targetEntity="Pets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pet_id", referencedColumnName="id")
     * })
     */
    private $pet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPetlover(): \Users
    {
        return $this->petlover;
    }

    public function setPetlover(?Users $petlover): self
    {
        $this->petlover = $petlover;

        return $this;
    }

    public function getPet(): \App\Entity\Pets
    {
        return $this->pet;
    }

    public function setPet(?Pets $pet): self
    {
        $this->pet = $pet;

        return $this;
    }


}
