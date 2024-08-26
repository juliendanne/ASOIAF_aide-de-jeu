<?php

namespace App\Entity;

use App\Repository\LineCommanderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineCommanderRepository::class)
 */
class LineCommander
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commander::class, inversedBy="lineCommanders")
     */
    private $commander;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lineCommanders")
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity=LineArmy::class, inversedBy="lineCommander", cascade={"persist", "remove"})
     */
    private $linkLineArmy;

    /**
     * @ORM\ManyToOne(targetEntity=Army::class, inversedBy="lineCommanders")
     */
    private $army;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommander(): ?Commander
    {
        return $this->commander;
    }

    public function setCommander(?Commander $commander): self
    {
        $this->commander = $commander;

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

    public function getLinkLineArmy(): ?LineArmy
    {
        return $this->linkLineArmy;
    }

    public function setLinkLineArmy(?LineArmy $linkLineArmy): self
    {
        $this->linkLineArmy = $linkLineArmy;

        return $this;
    }

    public function getArmy(): ?Army
    {
        return $this->army;
    }

    public function setArmy(?Army $army): self
    {
        $this->army = $army;

        return $this;
    }
}
