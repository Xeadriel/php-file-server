<?php

namespace App\Entity;

use App\Repository\WikiPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WikiPageRepository::class)]
class WikiPage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rawHTMLPath = null;

    #[ORM\ManyToOne(inversedBy: 'wikiPages')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $creator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRawHTMLPath(): ?string
    {
        return $this->rawHTMLPath;
    }

    public function setRawHTMLPath(string $rawHTMLPath): static
    {
        $this->rawHTMLPath = $rawHTMLPath;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }
}
