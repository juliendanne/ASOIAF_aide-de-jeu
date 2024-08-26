<?php

namespace App\Entity;

use App\Repository\ArmyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArmyRepository::class)
 */
class Army
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $limit_cost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total_cost;

    /**
     * @ORM\ManyToOne(targetEntity=Commander::class, inversedBy="armies")
     */
    private $commander;

    /**
     * @ORM\OneToMany(targetEntity=NoCombatUnit::class, mappedBy="army")
     */
    private $link_ncu;



    /**
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="armies")
     */
    private $faction;



    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="armies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $armyUser;

    /**
     * @ORM\OneToMany(targetEntity=LineArmy::class, mappedBy="army", orphanRemoval=true)
     */
    private $lineArmies;

    /**
     * @ORM\ManyToMany(targetEntity=CombatUnit::class, inversedBy="armies")
     */
    private $linkCombatUnit;

    /**
     * @ORM\OneToMany(targetEntity=LineAttachment::class, mappedBy="army")
     */
    private $lineAttachments;



    /**
     * @ORM\OneToMany(targetEntity=LineNCU::class, mappedBy="army")
     */
    private $lineNCUs;

    /**
     * @ORM\ManyToMany(targetEntity=NoCombatUnit::class, inversedBy="armies")
     */
    private $linkNCU;

    /**
     * @ORM\OneToMany(targetEntity=LineCommander::class, mappedBy="army")
     */
    private $lineCommanders;





    public function __construct()
    {
        $this->link_ncu = new ArrayCollection();
        $this->link_combatUnit = new ArrayCollection();
        $this->lineArmies = new ArrayCollection();
        $this->combatUnits = new ArrayCollection();
        $this->linkCombatUnit = new ArrayCollection();
        $this->lineAttachments = new ArrayCollection();
        $this->linkNCU = new ArrayCollection();
        $this->lineNCUs = new ArrayCollection();
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

    public function getLimitCost(): ?int
    {
        return $this->limit_cost;
    }

    public function setLimitCost(int $limit_cost): self
    {
        $this->limit_cost = $limit_cost;

        return $this;
    }

    public function getTotalCost(): ?int
    {
        return $this->total_cost;
    }

    public function setTotalCost(?int $total_cost): self
    {
        $this->total_cost = $total_cost;

        return $this;
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





    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): self
    {
        $this->faction = $faction;

        return $this;
    }



    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getArmyUser(): ?User
    {
        return $this->armyUser;
    }

    public function setArmyUser(?User $armyUser): self
    {
        $this->armyUser = $armyUser;

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
            $lineArmy->setArmy($this);
        }

        return $this;
    }

    public function removeLineArmy(LineArmy $lineArmy): self
    {
        if ($this->lineArmies->removeElement($lineArmy)) {
            // set the owning side to null (unless already changed)
            if ($lineArmy->getArmy() === $this) {
                $lineArmy->setArmy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CombatUnit>
     */
    public function getLinkCombatUnit(): Collection
    {
        return $this->linkCombatUnit;
    }

    public function addLinkCombatUnit(CombatUnit $linkCombatUnit): self
    {
        if (!$this->linkCombatUnit->contains($linkCombatUnit)) {
            $this->linkCombatUnit[] = $linkCombatUnit;
        }

        return $this;
    }

    public function removeLinkCombatUnit(CombatUnit $linkCombatUnit): self
    {
        $this->linkCombatUnit->removeElement($linkCombatUnit);

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
            $lineAttachment->setArmy($this);
        }

        return $this;
    }

    public function removeLineAttachment(LineAttachment $lineAttachment): self
    {
        if ($this->lineAttachments->removeElement($lineAttachment)) {
            // set the owning side to null (unless already changed)
            if ($lineAttachment->getArmy() === $this) {
                $lineAttachment->setArmy(null);
            }
        }

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
            $lineNCUs->setArmy($this);
        }

        return $this;
    }

    public function removeLineNCUs(LineNCU $lineNCUs): self
    {
        if ($this->lineNCUs->removeElement($lineNCUs)) {
            // set the owning side to null (unless already changed)
            if ($lineNCUs->getArmy() === $this) {
                $lineNCUs->setArmy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NoCombatUnit>
     */
    public function getLinkNCU(): Collection
    {
        return $this->linkNCU;
    }

    public function addLinkNCU(NoCombatUnit $linkNCU): self
    {
        if (!$this->linkNCU->contains($linkNCU)) {
            $this->linkNCU[] = $linkNCU;
        }

        return $this;
    }

    public function removeLinkNCU(NoCombatUnit $linkNCU): self
    {
        $this->linkNCU->removeElement($linkNCU);

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
            $lineCommander->setArmy($this);
        }

        return $this;
    }

    public function removeLineCommander(LineCommander $lineCommander): self
    {
        if ($this->lineCommanders->removeElement($lineCommander)) {
            // set the owning side to null (unless already changed)
            if ($lineCommander->getArmy() === $this) {
                $lineCommander->setArmy(null);
            }
        }

        return $this;
    }

 


}
