<?php

class Project
{

    public function __construct(private string $title, private string $content,
                                private ?int $user_id, private DateTime $created_at = new DateTime(), private ?int $id = null)
    {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Project
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Project
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): Project
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): Project
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): Project
    {
        $this->id = $id;
        return $this;
    }



}