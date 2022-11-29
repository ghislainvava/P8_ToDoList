<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity("email", message: "Cet email est déjà utilisé")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Vous devez saisir un nom d'utilisateur.")]
    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min:8, minMessage: "Votre mot de passe doit posséder au moins 8 caractères")]
    //#[Assert\EqualTo(propertyPath: "confirm_password", message:"Vous n'avez donné le même mot de passe ")]
    private $password;
   
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min:2, max: 180)]
    #[Assert\Email(message:"Vous devez saisir un nom email valide.")]
    private $email;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Task::class)]
    private Collection $author;

    public function __construct()
    {
        $this->author = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password):self 
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

   public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return array<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
    
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
     public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    public function eraseCredentials()
    {
    }

    /**
     * @return Collection<int, Task>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Task $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
            $author->setUser($this);
        }

        return $this;
    }

    public function removeAuthor(Task $author): self
    {
        if ($this->author->removeElement($author)) {
            // set the owning side to null (unless already changed)
            if ($author->getUser() === $this) {
                $author->setUser(null);
            }
        }

        return $this;
    }
}
