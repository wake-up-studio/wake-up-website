<?php
class Service
{
    public function __construct(private string $title, private string $content, private DateTime $created_at = new DateTime(), private ?int $id = null)
    {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Service
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Service
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): Service
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Service
    {
        $this->id = $id;
        return $this;
    }



}