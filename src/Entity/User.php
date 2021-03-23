<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *     min=8,
     *     minMessage="Le mot de passe doit contenir au moins {{ limit }} caractères"
     * )
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validated;

    /**
     * @ORM\OneToMany(targetEntity=TrickComment::class, mappedBy="user", orphanRemoval=true)
     */
    private $trickComments;

    /**
     * @ORM\OneToOne(targetEntity=UserResetPasswordToken::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userResetPasswordToken;

    /**
     * @ORM\OneToOne(targetEntity=UserValidationToken::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userValidationToken;

    public function __construct()
    {
        $this->validated = false;

        $this->trickComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array();
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
     * @return Collection|TrickComment[]
     */
    public function getTrickComments(): Collection
    {
        return $this->trickComments;
    }

    public function addTrickComment(TrickComment $trickComment): self
    {
        if (!$this->trickComments->contains($trickComment)) {
            $this->trickComments[] = $trickComment;
            $trickComment->setUser($this);
        }

        return $this;
    }

    public function removeTrickComment(TrickComment $trickComment): self
    {
        if ($this->trickComments->removeElement($trickComment)) {
            // set the owning side to null (unless already changed)
            if ($trickComment->getUser() === $this) {
                $trickComment->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getUserResetPasswordToken(): ?UserResetPasswordToken
    {
        return $this->userResetPasswordToken;
    }

    public function setUserResetPasswordToken(UserResetPasswordToken $userResetPasswordToken): self
    {
        // set the owning side of the relation if necessary
        if ($userResetPasswordToken->getUser() !== $this) {
            $userResetPasswordToken->setUser($this);
        }

        $this->userResetPasswordToken = $userResetPasswordToken;

        return $this;
    }

    public function getUserValidationToken(): ?UserValidationToken
    {
        return $this->userValidationToken;
    }

    public function setUserValidationToken(UserValidationToken $userValidationToken): self
    {
        // set the owning side of the relation if necessary
        if ($userValidationToken->getUser() !== $this) {
            $userValidationToken->setUser($this);
        }

        $this->userValidationToken = $userValidationToken;

        return $this;
    }
}
