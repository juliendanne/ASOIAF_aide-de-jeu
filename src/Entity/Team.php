<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="teams")
     */
    private $teamLinkForGame;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="teams")
     */
    private $playersInTeam;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $teamStatut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modifDate;

    public function __construct()
    {
        $this->playersInTeam = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamLinkForGame(): ?Game
    {
        return $this->teamLinkForGame;
    }

    public function setTeamLinkForGame(?Game $teamLinkForGame): self
    {
        $this->teamLinkForGame = $teamLinkForGame;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayersInTeam(): Collection
    {
        return $this->playersInTeam;
    }

    public function addPlayersInTeam(User $playersInTeam): self
    {
        if (!$this->playersInTeam->contains($playersInTeam)) {
            $this->playersInTeam[] = $playersInTeam;
        }

        return $this;
    }

    public function removePlayersInTeam(User $playersInTeam): self
    {
        $this->playersInTeam->removeElement($playersInTeam);

        return $this;
    }

    public function isTeamStatut(): ?bool
    {
        return $this->teamStatut;
    }

    public function setTeamStatut(?bool $teamStatut): self
    {
        $this->teamStatut = $teamStatut;

        return $this;
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(?\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModifDate(): ?\DateTimeInterface
    {
        return $this->modifDate;
    }

    public function setModifDate(?\DateTimeInterface $modifDate): self
    {
        $this->modifDate = $modifDate;

        return $this;
    }
}
