<?php
class Question
{

    public function __construct(private string $content, private ?int $form_id, private ?int $id = null)
    {

    }

    public function getFormId(): ?int
    {
        return $this->form_id;
    }

    public function setFormId(int $form_id): Question
    {
        $this->form_id = $form_id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Question
    {
        $this->content = $content;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Question
    {
        $this->id = $id;
        return $this;
    }



}