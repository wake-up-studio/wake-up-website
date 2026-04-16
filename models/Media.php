<?php

class Media
{
public function __construct(private string $alt, private string $url, private ?int $id = null)
    {

    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): Media
    {
        $this->alt = $alt;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Media
    {
        $this->url = $url;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Media
    {
        $this->id = $id;
        return $this;
    }



}