<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[HasLifecycleCallbacks]
class Post
{
    use \App\Traits\LifecycleTrackerTrait; // importe et instancie la classe LifecycleTrakerTrait

    #[ORM\Id]
    #[ORM\GeneratedValue] // équivaut à l'auto-increment
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private bool $published = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $author = null;

    #[ORM\Column(length: 255, unique : true)] // slug est une chaine de caractère
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getSlug(): ?string 
    {
        return $this->slug;
    }

    // #[ORM\PrePersist] // au moment où l'on créé le post dans la bdd on fait la méthode suivante :
    // #[ORM\PreUpdate] // idem pour la mise à jour
    public function setSlug(): static // permet de modifer le titre en format slug
    {
        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($this->title)->lower(); // créer et nettoie le titre au format slug
        unset($slugger);
        return $this;
    }

    #[ORM\PrePersist] // au moment où l'on créé le post dans la bdd on fait la méthode suivante :
    #[ORM\PreUpdate] // idem pour la mise à jour
    public function setSlugValue(): void // permet de modifer le titre en format slug
    {
        $slugger = new AsciiSlugger();
        $this->slug = $slugger->slug($this->title)->lower(); // créer et nettoie le titre au format slug
        unset($slugger);
    }
    
}

