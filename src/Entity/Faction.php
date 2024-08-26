<?php

namespace App\Entity;

use App\Repository\FactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactionRepository::class)
 */
class Faction
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
     * @ORM\OneToMany(targetEntity=CombatUnit::class, mappedBy="faction", orphanRemoval=true)
     */
    private $combatUnits;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="faction", orphanRemoval=true)
     */
    private $attachments;

    /**
     * @ORM\OneToMany(targetEntity=Commander::class, mappedBy="faction", orphanRemoval=true)
     */
    private $commanders;

    /**
     * @ORM\OneToMany(targetEntity=NoCombatUnit::class, mappedBy="faction", orphanRemoval=true)
     */
    private $noCombatUnits;

    /**
     * @ORM\OneToMany(targetEntity=Army::class, mappedBy="faction")
     */
    private $armies;

    public function __toString() {
        return $this->name;
    }
    public function __construct()
    {
        $this->combatUnits = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->commanders = new ArrayCollection();
        $this->noCombatUnits = new ArrayCollection();
        $this->armies = new ArrayCollection();
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
     * @return Collection<int, CombatUnit>
     */
    public function getCombatUnits(): Collection
    {
        return $this->combatUnits;
    }

    public function addCombatUnit(CombatUnit $combatUnit): self
    {
        if (!$this->combatUnits->contains($combatUnit)) {
            $this->combatUnits[] = $combatUnit;
            $combatUnit->setFaction($this);
        }

        return $this;
    }

    public function removeCombatUnit(CombatUnit $combatUnit): self
    {
        if ($this->combatUnits->removeElement($combatUnit)) {
            // set the owning side to null (unless already changed)
            if ($combatUnit->getFaction() === $this) {
                $combatUnit->setFaction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Attachment>
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setFaction($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getFaction() === $this) {
                $attachment->setFaction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commander>
     */
    public function getCommanders(): Collection
    {
        return $this->commanders;
    }

    public function addCommander(Commander $commander): self
    {
        if (!$this->commanders->contains($commander)) {
            $this->commanders[] = $commander;
            $commander->setFaction($this);
        }

        return $this;
    }

    public function removeCommander(Commander $commander): self
    {
        if ($this->commanders->removeElement($commander)) {
            // set the owning side to null (unless already changed)
            if ($commander->getFaction() === $this) {
                $commander->setFaction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoCombatUnit>
     */
    public function getNoCombatUnits(): Collection
    {
        return $this->noCombatUnits;
    }

    public function addNoCombatUnit(NoCombatUnit $noCombatUnit): self
    {
        if (!$this->noCombatUnits->contains($noCombatUnit)) {
            $this->noCombatUnits[] = $noCombatUnit;
            $noCombatUnit->setFaction($this);
        }

        return $this;
    }

    public function removeNoCombatUnit(NoCombatUnit $noCombatUnit): self
    {
        if ($this->noCombatUnits->removeElement($noCombatUnit)) {
            // set the owning side to null (unless already changed)
            if ($noCombatUnit->getFaction() === $this) {
                $noCombatUnit->setFaction(null);
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
            $army->setFaction($this);
        }

        return $this;
    }

    public function removeArmy(Army $army): self
    {
        if ($this->armies->removeElement($army)) {
            // set the owning side to null (unless already changed)
            if ($army->getFaction() === $this) {
                $army->setFaction(null);
            }
        }

        return $this;
    }
}
