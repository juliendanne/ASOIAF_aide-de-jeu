<?php

namespace App\Entity;

use App\Repository\TypeOfUnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeOfUnitRepository::class)
 */
class TypeOfUnit
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
     * @ORM\OneToMany(targetEntity=CombatUnit::class, mappedBy="typeOfUnit", orphanRemoval=true)
     */
    private $combatUnits;

    /**
     * @ORM\OneToMany(targetEntity=Attachment::class, mappedBy="type", orphanRemoval=true)
     */
    private $attachments;

    /**
     * @ORM\OneToMany(targetEntity=Commander::class, mappedBy="type", orphanRemoval=true)
     */
    private $commanders;

    public function __construct()
    {
        $this->combatUnits = new ArrayCollection();
        $this->attachments = new ArrayCollection();
        $this->commanders = new ArrayCollection();
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
            $combatUnit->setTypeOfUnit($this);
        }

        return $this;
    }

    public function removeCombatUnit(CombatUnit $combatUnit): self
    {
        if ($this->combatUnits->removeElement($combatUnit)) {
            // set the owning side to null (unless already changed)
            if ($combatUnit->getTypeOfUnit() === $this) {
                $combatUnit->setTypeOfUnit(null);
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
            $attachment->setType($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->removeElement($attachment)) {
            // set the owning side to null (unless already changed)
            if ($attachment->getType() === $this) {
                $attachment->setType(null);
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
            $commander->setType($this);
        }

        return $this;
    }

    public function removeCommander(Commander $commander): self
    {
        if ($this->commanders->removeElement($commander)) {
            // set the owning side to null (unless already changed)
            if ($commander->getType() === $this) {
                $commander->setType(null);
            }
        }

        return $this;
    }
}
