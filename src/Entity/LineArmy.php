<?php

namespace App\Entity;

use App\Repository\LineArmyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineArmyRepository::class)
 */
class LineArmy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Army::class, inversedBy="lineArmies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $army;

    /**
     * @ORM\ManyToOne(targetEntity=CombatUnit::class, inversedBy="lineArmies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $combatUnit;

    /**
     * @ORM\OneToMany(targetEntity=LineAttachment::class, mappedBy="lineArmy")
     */
    private $lineAttachments;

    /**
     * @ORM\ManyToMany(targetEntity=Attachment::class, inversedBy="lineArmies")
     */
    private $attachments;

    /**
     * @ORM\OneToOne(targetEntity=LineCommander::class, mappedBy="linkLineArmy", cascade={"persist", "remove"})
     */
    private $lineCommander;

    public function __construct()
    {
        $this->lineAttachments = new ArrayCollection();
        $this->attachments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getCombatUnit(): ?CombatUnit
    {
        return $this->combatUnit;
    }

    public function setCombatUnit(?CombatUnit $combatUnit): self
    {
        $this->combatUnit = $combatUnit;

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
            $lineAttachment->setLineArmy($this);
        }

        return $this;
    }

    public function removeLineAttachment(LineAttachment $lineAttachment): self
    {
        if ($this->lineAttachments->removeElement($lineAttachment)) {
            // set the owning side to null (unless already changed)
            if ($lineAttachment->getLineArmy() === $this) {
                $lineAttachment->setLineArmy(null);
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
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        $this->attachments->removeElement($attachment);

        return $this;
    }

    public function getLineCommander(): ?LineCommander
    {
        return $this->lineCommander;
    }

    public function setLineCommander(?LineCommander $lineCommander): self
    {
        // unset the owning side of the relation if necessary
        if ($lineCommander === null && $this->lineCommander !== null) {
            $this->lineCommander->setLinkLineArmy(null);
        }

        // set the owning side of the relation if necessary
        if ($lineCommander !== null && $lineCommander->getLinkLineArmy() !== $this) {
            $lineCommander->setLinkLineArmy($this);
        }

        $this->lineCommander = $lineCommander;

        return $this;
    }
}
