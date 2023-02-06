<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notifsOfAuthor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notifAuthor;

 

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="notifications")
     */
    private $game;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $object;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notifications")
     */
    private $addressee;







    public function __construct()
    {
        $this->addressee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotifAuthor(): ?User
    {
        return $this->notifAuthor;
    }

    public function setNotifAuthor(?User $notifAuthor): self
    {
        $this->notifAuthor = $notifAuthor;

        return $this;
    }

 

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
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

    public function getAddressee(): ?User
    {
        return $this->addressee;
    }

    public function setAddressee(?User $addressee): self
    {
        $this->addressee = $addressee;

        return $this;
    }






}
