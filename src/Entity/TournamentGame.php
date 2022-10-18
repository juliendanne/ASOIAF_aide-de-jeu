<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\TournamentGameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TournamentGameRepository::class)
 */
class TournamentGame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("api")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=NbJoueur::class, inversedBy="tournamentGames")
     */
    private $nbJoueur;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="tournamentGame")
     */
    private $games;

    public function __construct()
    {
        $this->nbJoueur = new ArrayCollection();
        $this->games = new ArrayCollection();
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

    /**
     * @return Collection<int, NbJoueur>
     */
    public function getNbJoueur(): Collection
    {
        return $this->nbJoueur;
    }

    public function addNbJoueur(NbJoueur $nbJoueur): self
    {
        if (!$this->nbJoueur->contains($nbJoueur)) {
            $this->nbJoueur[] = $nbJoueur;
        }

        return $this;
    }

    public function removeNbJoueur(NbJoueur $nbJoueur): self
    {
        $this->nbJoueur->removeElement($nbJoueur);

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
            $game->setTournamentGame($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTournamentGame() === $this) {
                $game->setTournamentGame(null);
            }
        }

        return $this;
    }
}
