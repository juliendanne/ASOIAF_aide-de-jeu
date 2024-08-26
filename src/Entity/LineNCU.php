<?php

namespace App\Entity;

use App\Repository\LineNCURepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineNCURepository::class)
 */
class LineNCU
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Army::class, inversedBy="lineNCUs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $army;

    /**
     * @ORM\ManyToOne(targetEntity=NoCombatUnit::class, inversedBy="lineNCUs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $noCombatUnit;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNoCombatUnit(): ?NoCombatUnit
    {
        return $this->noCombatUnit;
    }

    public function setNoCombatUnit(?NoCombatUnit $noCombatUnit): self
    {
        $this->noCombatUnit = $noCombatUnit;

        return $this;
    }
}
