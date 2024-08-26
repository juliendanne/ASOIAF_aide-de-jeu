<?php

namespace App\Entity;

use App\Repository\NoCombatUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoCombatUnitRepository::class)
 */
class NoCombatUnit
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
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="noCombatUnits")
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
     * @ORM\OneToMany(targetEntity=LineNCU::class, mappedBy="noCombatUnit")
     */
    private $lineNCUs;

    /**
     * @ORM\ManyToMany(targetEntity=Army::class, mappedBy="linkNCU")
     */
    private $armies;

    public function __construct()
    {
        $this->armies = new ArrayCollection();
        $this->lineNCUs = new ArrayCollection();
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



    /**
     * @return Collection<int, LineNCU>
     */
    public function getLineNCUs(): Collection
    {
        return $this->lineNCUs;
    }

    public function addLineNCUs(LineNCU $lineNCUs): self
    {
        if (!$this->lineNCUs->contains($lineNCUs)) {
            $this->lineNCUs[] = $lineNCUs;
            $lineNCUs->setNoCombatUnit($this);
        }

        return $this;
    }

    public function removeLineNCUs(LineNCU $lineNCUs): self
    {
        if ($this->lineNCUs->removeElement($lineNCUs)) {
            // set the owning side to null (unless already changed)
            if ($lineNCUs->getNoCombatUnit() === $this) {
                $lineNCUs->setNoCombatUnit(null);
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
            $army->addLinkNCU($this);
        }

        return $this;
    }

    public function removeArmy(Army $army): self
    {
        if ($this->armies->removeElement($army)) {
            $army->removeLinkNCU($this);
        }

        return $this;
    }

}
