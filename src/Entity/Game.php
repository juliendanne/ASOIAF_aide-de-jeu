<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
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
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="teamLinkForGame")
     */
    private $teams;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="gamesOfAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="gamesjoined")
     */
    private $playersjoined;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $authorIsPlayer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $format;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $tournamentGame;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbTotalPlayer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbOfTeam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbOfGame;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gameStatut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modifDate;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="game")
     */
    private $notifications;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->playersjoined = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setTeamLinkForGame($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getTeamLinkForGame() === $this) {
                $team->setTeamLinkForGame(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getPlayersjoined(): Collection
    {
        return $this->playersjoined;
    }

    public function addPlayersjoined(User $playersjoined): self
    {
        if (!$this->playersjoined->contains($playersjoined)) {
            $this->playersjoined[] = $playersjoined;
        }

        return $this;
    }

    public function removePlayersjoined(User $playersjoined): self
    {
        $this->playersjoined->removeElement($playersjoined);

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isAuthorIsPlayer(): ?bool
    {
        return $this->authorIsPlayer;
    }

    public function setAuthorIsPlayer(?bool $authorIsPlayer): self
    {
        $this->authorIsPlayer = $authorIsPlayer;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function isTournamentGame(): ?bool
    {
        return $this->tournamentGame;
    }

    public function setTournamentGame(?bool $tournamentGame): self
    {
        $this->tournamentGame = $tournamentGame;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getNbTotalPlayer(): ?int
    {
        return $this->nbTotalPlayer;
    }

    public function setNbTotalPlayer(?int $nbTotalPlayer): self
    {
        $this->nbTotalPlayer = $nbTotalPlayer;

        return $this;
    }

    public function getNbOfTeam(): ?int
    {
        return $this->nbOfTeam;
    }

    public function setNbOfTeam(?int $nbOfTeam): self
    {
        $this->nbOfTeam = $nbOfTeam;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getNbOfGame(): ?int
    {
        return $this->nbOfGame;
    }

    public function setNbOfGame(int $nbOfGame): self
    {
        $this->nbOfGame = $nbOfGame;

        return $this;
    }

    public function getGameStatut(): ?string
    {
        return $this->gameStatut;
    }

    public function setGameStatut(?string $gameStatut): self
    {
        $this->gameStatut = $gameStatut;

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

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setGame($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getGame() === $this) {
                $notification->setGame(null);
            }
        }

        return $this;
    }
}
