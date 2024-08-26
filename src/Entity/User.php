<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $creationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $modifDate;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, mappedBy="playersInTeam")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="author")
     */
    private $gamesOfAuthor;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, mappedBy="playersjoined")
     */
    private $gamesjoined;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="notifAuthor")
     */
    private $notifsOfAuthor;



    /**
     * @ORM\OneToMany(targetEntity=StatutPlayer::class, mappedBy="players")
     */
    private $statutsOfPlayer;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="addressee")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity=Army::class, mappedBy="armyUser", orphanRemoval=true)
     */
    private $armies;

    /**
     * @ORM\OneToMany(targetEntity=LineAttachment::class, mappedBy="author")
     */
    private $lineAttachments;

    /**
     * @ORM\OneToMany(targetEntity=LineCommander::class, mappedBy="author")
     */
    private $lineCommanders;



 





 

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->gamesOfAuthor = new ArrayCollection();
        $this->gamesjoined = new ArrayCollection();
        $this->notifsOfAuthor = new ArrayCollection();
        $this->notifsOfAddressee = new ArrayCollection();
        $this->statutsOfPlayer = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->notificationsOk = new ArrayCollection();
        $this->armies = new ArrayCollection();
        $this->lineAttachments = new ArrayCollection();
        $this->lineCommanders = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

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
            $team->addPlayersInTeam($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            $team->removePlayersInTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGamesOfAuthor(): Collection
    {
        return $this->gamesOfAuthor;
    }

    public function addGamesOfAuthor(Game $gamesOfAuthor): self
    {
        if (!$this->gamesOfAuthor->contains($gamesOfAuthor)) {
            $this->gamesOfAuthor[] = $gamesOfAuthor;
            $gamesOfAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeGamesOfAuthor(Game $gamesOfAuthor): self
    {
        if ($this->gamesOfAuthor->removeElement($gamesOfAuthor)) {
            // set the owning side to null (unless already changed)
            if ($gamesOfAuthor->getAuthor() === $this) {
                $gamesOfAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGamesjoined(): Collection
    {
        return $this->gamesjoined;
    }

    public function addGamesjoined(Game $gamesjoined): self
    {
        if (!$this->gamesjoined->contains($gamesjoined)) {
            $this->gamesjoined[] = $gamesjoined;
            $gamesjoined->addPlayersjoined($this);
        }

        return $this;
    }

    public function removeGamesjoined(Game $gamesjoined): self
    {
        if ($this->gamesjoined->removeElement($gamesjoined)) {
            $gamesjoined->removePlayersjoined($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifsOfAuthor(): Collection
    {
        return $this->notifsOfAuthor;
    }

    public function addNotifsOfAuthor(Notification $notifsOfAuthor): self
    {
        if (!$this->notifsOfAuthor->contains($notifsOfAuthor)) {
            $this->notifsOfAuthor[] = $notifsOfAuthor;
            $notifsOfAuthor->setNotifAuthor($this);
        }

        return $this;
    }

    public function removeNotifsOfAuthor(Notification $notifsOfAuthor): self
    {
        if ($this->notifsOfAuthor->removeElement($notifsOfAuthor)) {
            // set the owning side to null (unless already changed)
            if ($notifsOfAuthor->getNotifAuthor() === $this) {
                $notifsOfAuthor->setNotifAuthor(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, StatutPlayer>
     */
    public function getStatutsOfPlayer(): Collection
    {
        return $this->statutsOfPlayer;
    }

    public function addStatutsOfPlayer(StatutPlayer $statutsOfPlayer): self
    {
        if (!$this->statutsOfPlayer->contains($statutsOfPlayer)) {
            $this->statutsOfPlayer[] = $statutsOfPlayer;
            $statutsOfPlayer->setPlayers($this);
        }

        return $this;
    }

    public function removeStatutsOfPlayer(StatutPlayer $statutsOfPlayer): self
    {
        if ($this->statutsOfPlayer->removeElement($statutsOfPlayer)) {
            // set the owning side to null (unless already changed)
            if ($statutsOfPlayer->getPlayers() === $this) {
                $statutsOfPlayer->setPlayers(null);
            }
        }

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
            $notification->setAddressee($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getAddressee() === $this) {
                $notification->setAddressee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Army>
     */
    public function getArmies(): Collection
    {
        return $this->armies;
    }

    public function addArmy(Army $army): self
    {
        if (!$this->armies->contains($army)) {
            $this->armies[] = $army;
            $army->setArmyUser($this);
        }

        return $this;
    }

    public function removeArmy(Army $army): self
    {
        if ($this->armies->removeElement($army)) {
            // set the owning side to null (unless already changed)
            if ($army->getArmyUser() === $this) {
                $army->setArmyUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LineAttachment>
     */
    public function getLineAttachments(): Collection
    {
        return $this->lineAttachments;
    }

    public function addLineAttachment(LineAttachment $lineAttachment): self
    {
        if (!$this->lineAttachments->contains($lineAttachment)) {
            $this->lineAttachments[] = $lineAttachment;
            $lineAttachment->setAuthor($this);
        }

        return $this;
    }

    public function removeLineAttachment(LineAttachment $lineAttachment): self
    {
        if ($this->lineAttachments->removeElement($lineAttachment)) {
            // set the owning side to null (unless already changed)
            if ($lineAttachment->getAuthor() === $this) {
                $lineAttachment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LineCommander>
     */
    public function getLineCommanders(): Collection
    {
        return $this->lineCommanders;
    }

    public function addLineCommander(LineCommander $lineCommander): self
    {
        if (!$this->lineCommanders->contains($lineCommander)) {
            $this->lineCommanders[] = $lineCommander;
            $lineCommander->setAuthor($this);
        }

        return $this;
    }

    public function removeLineCommander(LineCommander $lineCommander): self
    {
        if ($this->lineCommanders->removeElement($lineCommander)) {
            // set the owning side to null (unless already changed)
            if ($lineCommander->getAuthor() === $this) {
                $lineCommander->setAuthor(null);
            }
        }

        return $this;
    }







   
}
