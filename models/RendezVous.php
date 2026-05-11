<?php

class RendezVous
{
    public function __construct(private DateTime $date = new DateTime(), private DateTime $starting_time = new DateTime(), private DateTime $ending_time = new DateTime(),
                                private string $motif, private int $user_id, private ?int $id = null)
    {

    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    public function getStartingTime(): DateTime
    {
        return $this->starting_time;
    }

    public function setStartingTime(DateTime $starting_time): void
    {
        $this->starting_time = $starting_time;
    }

    public function getEndingTime(): DateTime
    {
        return $this->ending_time;
    }

    public function setEndingTime(DateTime $ending_time): void
    {
        $this->ending_time = $ending_time;
    }


    public function getMotif(): string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): void
    {
        $this->motif = $motif;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }



}