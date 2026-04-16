<?php

class Form
{
    public function __construct(private int $user_id, private string $content, private string $created_at = new DateTime(), private ?int $id = null)
    {

    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): Form
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Form
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at): Form
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Form
    {
        $this->id = $id;
        return $this;
    }



}