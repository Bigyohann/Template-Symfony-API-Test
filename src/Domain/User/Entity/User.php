<?php

namespace App\Domain\User\Entity;

use App\Domain\Main\Entity\TimeStampableTrait;
use App\Domain\Post\Entity\Post;
use App\Domain\User\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimeStampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(groups: ['admin:read'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(groups: ['user:read', 'user:register', 'user:update'])]
    #[Assert\Email(groups: ['user:register', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:register'])]
    private string $email;

    #[ORM\Column(type: 'json')]
    #[Groups(groups: ['admin:read'])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(groups: ['user:register'])]
    #[Assert\NotBlank(groups: ['user:register'])]
    private string $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(groups: ['user:read', 'user:register', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:register'])]
    private string $firstName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(groups: ['user:read', 'user:register', 'user:update'])]
    #[Assert\NotBlank(groups: ['user:register'])]
    private string $lastName;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

}
