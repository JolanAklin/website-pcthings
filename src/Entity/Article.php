<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Date::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $headerImage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $pathTitle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublicationDate(): ?Date
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?Date $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getHeaderImage(): ?Image
    {
        return $this->headerImage;
    }

    public function setHeaderImage(?Image $headerImage): self
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    public function getWriter(): ?User
    {
        return $this->writer;
    }

    public function setWriter(?User $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function getThumbnail(): ?Image
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?Image $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getPathTitle(): ?string
    {
        return $this->pathTitle;
    }

    public function setPathTitle(string $pathTitle): self
    {
        $this->pathTitle = $pathTitle;

        return $this;
    }
}
