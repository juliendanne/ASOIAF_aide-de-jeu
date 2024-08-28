<?php

namespace App\Entity;

use App\Repository\AttachmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttachmentRepository::class)
 */
class Attachment
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
     * @ORM\ManyToOne(targetEntity=CombatUnit::class, inversedBy="haveAttachment")
     */
    private $combatUnit;

    /**
     * @ORM\ManyToOne(targetEntity=Faction::class, inversedBy="attachments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_a_character;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $full_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity=TypeOfUnit::class, inversedBy="attachments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cardVerso;

    /**
     * @ORM\OneToMany(targetEntity=LineAttachment::class, mappedBy="attachment")
     */
    private $lineAttachments;

    /**
     * @ORM\ManyToMany(targetEntity=LineArmy::class, mappedBy="attachments")
     */
    private $lineArmies;

    public function __construct()
    {
        $this->lineAttachments = new ArrayCollection();
        $this->lineArmies = new ArrayCollection();
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

    public function getCombatUnit(): ?CombatUnit
    {
        return $this->combatUnit;
    }

    public function setCombatUnit(?CombatUnit $combatUnit): self
    {
        $this->combatUnit = $combatUnit;

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

    public function isIsACharacter(): ?bool
    {
        return $this->is_a_character;
    }

    public function setIsACharacter(bool $is_a_character): self
    {
        $this->is_a_character = $is_a_character;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(?string $full_name): self
    {
        $this->full_name = $full_name;

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

    public function getType(): ?TypeOfUnit
    {
        return $this->type;
    }

    public function setType(?TypeOfUnit $type): self
    {
        $this->type = $type;

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
            $lineAttachment->setAttachment($this);
        }

        return $this;
    }

    public function removeLineAttachment(LineAttachment $lineAttachment): self
    {
        if ($this->lineAttachments->removeElement($lineAttachment)) {
            // set the owning side to null (unless already changed)
            if ($lineAttachment->getAttachment() === $this) {
                $lineAttachment->setAttachment(null);
            }
        }

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
            $lineArmy->addAttachment($this);
        }

        return $this;
    }

    public function removeLineArmy(LineArmy $lineArmy): self
    {
        if ($this->lineArmies->removeElement($lineArmy)) {
            $lineArmy->removeAttachment($this);
        }

        return $this;
    }
}
