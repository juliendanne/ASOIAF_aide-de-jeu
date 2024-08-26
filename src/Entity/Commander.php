<?php

namespace App\Entity;

use App\Repository\CommanderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommanderRepository::class)
 */
class Commander
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="commanders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $full_name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_a_character;

    /**
     * @ORM\Column(type="boolean")
     */
    private $soloUnit;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardVerso;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfUnit::class, inversedBy="commanders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=CombatUnit::class, inversedBy="commander", cascade={"persist", "remove"})
     */
    private $attached_to_unit;

    /**
     * @ORM\OneToMany(targetEntity=Army::class, mappedBy="commander")
     */
    private $armies;

    /**
     * @ORM\OneToMany(targetEntity=LineCommander::class, mappedBy="commander")
     */
    private $lineCommanders;

    public function __construct()
    {
        $this->armies = new ArrayCollection();
        $this->lineCommanders = new ArrayCollection();
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

    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function isIsACharacter(): ?bool
    {
        return $this->is_a_character;
    }

    public function setIsACharacter(bool $is_a_character): self
    {
        $this->is_a_character = $is_a_character;

        return $this;
    }

    public function isSoloUnit(): ?bool
    {
        return $this->soloUnit;
    }

    public function setSoloUnit(bool $soloUnit): self
    {
        $this->soloUnit = $soloUnit;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCard(): ?string
    {
        return $this->card;
    }

    public function setCard(?string $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getCardVerso(): ?string
    {
        return $this->cardVerso;
    }

    public function setCardVerso(?string $cardVerso): self
    {
        $this->cardVerso = $cardVerso;

        return $this;
    }

    public function getType(): ?TypeOfUnit
    {
        return $this->type;
    }

    public function setType(?TypeOfUnit $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAttachedToUnit(): ?CombatUnit
    {
        return $this->attached_to_unit;
    }

    public function setAttachedToUnit(?CombatUnit $attached_to_unit): self
    {
        $this->attached_to_unit = $attached_to_unit;

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
            $army->setCommander($this);
        }

        return $this;
    }

    public function removeArmy(Army $army): self
    {
        if ($this->armies->removeElement($army)) {
            // set the owning side to null (unless already changed)
            if ($army->getCommander() === $this) {
                $army->setCommander(null);
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
            $lineCommander->setCommander($this);
        }

        return $this;
    }

    public function removeLineCommander(LineCommander $lineCommander): self
    {
        if ($this->lineCommanders->removeElement($lineCommander)) {
            // set the owning side to null (unless already changed)
            if ($lineCommander->getCommander() === $this) {
                $lineCommander->setCommander(null);
            }
        }

        return $this;
    }
}
