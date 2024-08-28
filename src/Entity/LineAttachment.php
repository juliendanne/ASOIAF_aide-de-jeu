<?php

namespace App\Entity;

use App\Repository\LineAttachmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineAttachmentRepository::class)
 */
class LineAttachment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LineArmy::class, inversedBy="lineAttachments")
     */
    private $lineArmy;

    /**
     * @ORM\ManyToOne(targetEntity=Attachment::class, inversedBy="lineAttachments")
     */
    private $attachment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lineAttachments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Army::class, inversedBy="lineAttachments")
     */
    private $army;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLineArmy(): ?LineArmy
    {
        return $this->lineArmy;
    }

    public function setLineArmy(?LineArmy $lineArmy): self
    {
        $this->lineArmy = $lineArmy;

        return $this;
    }
    

    public function getAttachment(): ?Attachment
    {
        return $this->attachment;
    }

    public function setAttachment(?Attachment $attachment): self
    {
        $this->attachment = $attachment;

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
