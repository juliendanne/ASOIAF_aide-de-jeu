<?php

namespace App\Entity;

use App\Repository\StatutPlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatutPlayerRepository::class)
 */
class StatutPlayer
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="statutPlayers")
     */
    private $teams;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="statutsOfPlayer")
     */
    private $players;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeams(): ?Team
    {
        return $this->teams;
    }

    public function setTeams(?Team $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getPlayers(): ?User
    {
        return $this->players;
    }

    public function setPlayers(?User $players): self
    {
        $this->players = $players;

        return $this;
    }
}


