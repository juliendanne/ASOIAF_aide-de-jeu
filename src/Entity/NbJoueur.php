<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\NbJoueurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=NbJoueurRepository::class)
 */
class NbJoueur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable="true")
     * @Groups("api")
     */
    private $nb;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="nbPlayer")
     */
    private $games;

    /**
     * @ORM\ManyToMany(targetEntity=TournamentGame::class, mappedBy="nbJoueur")
     */
    private $tournamentGames;

    public function __construct()
    {
        $this->games = new ArrayCollection();
        $this->tournamentGames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(int $nb): self
    {
        $this->nb = $nb;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setNbPlayer($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getNbPlayer() === $this) {
                $game->setNbPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TournamentGame>
     */
    public function getTournamentGames(): Collection
    {
        return $this->tournamentGames;
    }

    public function addTournamentGame(TournamentGame $tournamentGame): self
    {
        if (!$this->tournamentGames->contains($tournamentGame)) {
            $this->tournamentGames[] = $tournamentGame;
            $tournamentGame->addNbJoueur($this);
        }

        return $this;
    }

    public function removeTournamentGame(TournamentGame $tournamentGame): self
    {
        if ($this->tournamentGames->removeElement($tournamentGame)) {
            $tournamentGame->removeNbJoueur($this);
        }

        return $this;
    }
}
