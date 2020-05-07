<?php

namespace App\Entity;

use App\Entity\Team;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("email", message = "Cet employé est déja dans notre base de donnée")
 */
class User implements UserInterface
{
    const TEMPORARY_PASSWORD = "paprika";
    const SUFFIX_EMAIL = "@paprika.com";
    const AVATAR_URL =  "https://api.adorable.io/avatars/60/";

    /**
    *@ORM\PrePersist
    *@ORM\PreUpdate
    */
    public function initializeEmail()
    {
            $slugify = new Slugify();
            $this->email = $slugify->slugify($this->getFullName(),"."). self::SUFFIX_EMAIL;
    }

    /**
    *@ORM\PrePersist
    *@ORM\PreUpdate
    */
    public function initializeSlug()
    {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getFullName());
    }

    /**
    *@ORM\PrePersist
    */
    public function initializeAvatar()
    {
        if (empty($this->avatar)){
            $this->avatar = self::AVATAR_URL .$this->getLastName(). "." .$this->getFirstName(). "@paprika.png";
        }
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password = self::TEMPORARY_PASSWORD;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Vous devez indiquer le nom de l'employé")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Vous devez indiquer le prénom de l'employé")
     */
    private $firstName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLeader;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $workTeam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="missionUser", cascade={"persist", "remove"})
     */
    private $missions;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = ucfirst($lastName);

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = ucfirst($firstName);

        return $this;
    }

    public function getIsLeader(): ?bool
    {
        return $this->isLeader;
    }

    public function setIsLeader(bool $isLeader): self
    {
        $this->isLeader = $isLeader;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFullName(): string
    {
        return ucwords($this->lastName)." ".ucwords($this->firstName);
    }

    public function getIsMale(): ?bool
    {
        return $this->isMale;
    }

    public function setIsMale(bool $isMale): self
    {
        $this->isMale = $isMale;

        return $this;
    }

    public function getWorkTeam(): ?Team
    {
        return $this->workTeam;
    }

    public function setWorkTeam(?Team $workTeam): self
    {
        $this->workTeam = $workTeam;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setMissionUser($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->contains($mission)) {
            $this->missions->removeElement($mission);
            // set the owning side to null (unless already changed)
            if ($mission->getMissionUser() === $this) {
                $mission->setMissionUser(null);
            }
        }

        return $this;
    }
}
