<?php

namespace App\Entity;

use App\Repository\CombatUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CombatUnitRepository::class)
 */
class CombatUnit
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
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="combatUnits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfUnit::class, inversedBy="combatUnits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeOfUnit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $soloUnit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardVerso;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="combatUnit")
     */
    private $haveAttachment;

    /**
     * @ORM\OneToOne(targetEntity=Commander::class, mappedBy="attached_to_unit", cascade={"persist", "remove"})
     */
    private $commander;



    /**
     * @ORM\OneToMany(targetEntity=LineArmy::class, mappedBy="combatUnit", orphanRemoval=true)
     */
    private $lineArmies;

    /**
     * @ORM\ManyToMany(targetEntity=Army::class, mappedBy="linkCombatUnit")
     */
    private $armies;







    public function __construct()
    {
        $this->haveAttachment = new ArrayCollection();
        $this->armies = new ArrayCollection();
        $this->lineArmies = new ArrayCollection();
        $this->linkCombatUnit = new ArrayCollection();
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

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getTypeOfUnit(): ?TypeOfUnit
    {
        return $this->typeOfUnit;
    }

    public function setTypeOfUnit(?TypeOfUnit $typeOfUnit): self
    {
        $this->typeOfUnit = $typeOfUnit;

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

    /**
     * @return Collection<int, Attachment>
     */
    public function getHaveAttachment(): Collection
    {
        return $this->haveAttachment;
    }

    public function addHaveAttachment(Attachment $haveAttachment): self
    {
        if (!$this->haveAttachment->contains($haveAttachment)) {
            $this->haveAttachment[] = $haveAttachment;
            $haveAttachment->setCombatUnit($this);
        }

        return $this;
    }

    public function removeHaveAttachment(Attachment $haveAttachment): self
    {
        if ($this->haveAttachment->removeElement($haveAttachment)) {
            // set the owning side to null (unless already changed)
            if ($haveAttachment->getCombatUnit() === $this) {
                $haveAttachment->setCombatUnit(null);
            }
        }

        return $this;
    }

    public function getCommander(): ?Commander
    {
        return $this->commander;
    }

    public function setCommander(?Commander $commander): self
    {
        // unset the owning side of the relation if necessary
        if ($commander === null && $this->commander !== null) {
            $this->commander->setAttachedToUnit(null);
        }

        // set the owning side of the relation if necessary
        if ($commander !== null && $commander->getAttachedToUnit() !== $this) {
            $commander->setAttachedToUnit($this);
        }

        $this->commander = $commander;

        return $this;
    }



    /**
     * @return Collection<int, LineArmy>
     */
    public function getLineArmies(): Collection
    {
        return $this->lineArmies;
    }

    public function addLineArmy(LineArmy $lineArmy): self
    {
        if (!$this->lineArmies->contains($lineArmy)) {
            $this->lineArmies[] = $lineArmy;
            $lineArmy->setCombatUnit($this);
        }

        return $this;
    }

    public function removeLineArmy(LineArmy $lineArmy): self
    {
        if ($this->lineArmies->removeElement($lineArmy)) {
            // set the owning side to null (unless already changed)
            if ($lineArmy->getCombatUnit() === $this) {
                $lineArmy->setCombatUnit(null);
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
            $army->addLinkCombatUnit($this);
        }

        return $this;
    }

    public function removeArmy(Army $army): self
    {
        if ($this->armies->removeElement($army)) {
            $army->removeLinkCombatUnit($this);
        }

        return $this;
    }






}