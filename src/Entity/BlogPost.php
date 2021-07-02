<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 * @ORM\Table(indexes={@Index(name="search_index_blogpost", fields={"title", "contentIndexable"}, flags={"fulltext"})})
 */
class BlogPost
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
     * @ORM\Column(type="json")
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
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $writer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentIndexable;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        $this->setContentIndexable($this->JSONToText($content));

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

    public function getWriter(): ?User
    {
        return $this->writer;
    }

    public function setWriter(?User $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function getContentIndexable(): ?string
    {
        return $this->contentIndexable;
    }

    /**
     * return a text that can be indexed for search purposes
     */
    private function JSONToText($json) : string
    {
        $text = "";
        $json = json_decode($json, true);
        foreach ($json["pageContent"] as $key => $value) {
            $text .= " ".$value["Content"];
        };
        return urldecode($text);
    }

    private function setContentIndexable(?string $contentIndexable): self
    {
        $this->contentIndexable = $contentIndexable;

        return $this;
    }
}
