<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $leaderFirstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $leaderLastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="workTeam")
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBoss = 0;

    public function fullLeaderName(): string
    {
        return $this->leaderLastName. " " .$this->leaderFirstName ;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setWorkTeam($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getWorkTeam() === $this) {
                $user->setWorkTeam(null);
            }
        }

        return $this;
    }

    public function getIsBoss(): ?bool
    {
        return $this->isBoss;
    }

    public function setIsBoss(bool $isBoss): self
    {
        $this->isBoss = $isBoss;

        return $this;
    }
}
