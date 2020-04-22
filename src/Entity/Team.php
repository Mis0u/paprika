<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    public function __construct()
    {
        $this->teamName = $this->fullLeaderName();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $teamName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $leaderFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $leaderLastName;

    public function fullLeaderName(): string
    {
        return $this->leaderLastName. " " .$this->leaderFirstName ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getLeaderFirstName(): ?string
    {
        return $this->leaderFirstName;
    }

    public function setLeaderFirstName(string $leaderFirstName): self
    {
        $this->leaderFirstName = $leaderFirstName;

        return $this;
    }

    public function getLeaderLastName(): ?string
    {
        return $this->leaderLastName;
    }

    public function setLeaderLastName(string $leaderLastName): self
    {
        $this->leaderLastName = $leaderLastName;

        return $this;
    }
}
