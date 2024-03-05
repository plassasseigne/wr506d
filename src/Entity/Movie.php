<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['movie:read']]
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'The movie title is required')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'The movie description is required')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'The release date is required')]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'The duration is required')]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private Collection $actor;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\NotBlank(message: 'The category is required')]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0', nullable: true)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\Positive(message: 'The box office must be positive')]
    #[Assert\Range(
        min: 1,
        max: 1000000000,
        notInRangeMessage: 'The box office needs to have a value between {{ min }} and {{ max }}'
    )]
    private ?string $box_office = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\Positive(message: 'The metascore must be positive')]
    #[Assert\Range(
        min: 1,
        max: 100,
        notInRangeMessage: 'The metascore needs to have a value between {{ min }} and {{ max }}'
    )]
    private ?int $metascore = null;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getBoxOffice(): ?string
    {
        return $this->box_office;
    }

    public function setBoxOffice(string $box_office): static
    {
        $this->box_office = $box_office;

        return $this;
    }

    public function getMetascore(): ?int
    {
        return $this->metascore;
    }

    public function setMetascore(int $metascore): static
    {
        $this->metascore = $metascore;

        return $this;
    }
}
