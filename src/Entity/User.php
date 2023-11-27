<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $firstname = null;

    #[ORM\Column(length: 40)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\OneToMany(mappedBy: 'userRecipe', targetEntity: Recipe::class)]
    private Collection $userRecipes;

    #[ORM\OneToMany(mappedBy: 'favoriteRecipe', targetEntity: Recipe::class)]
    private Collection $favoritesRecipes;

    public function __construct()
    {
        $this->userRecipes = new ArrayCollection();
        $this->favoritesRecipes = new ArrayCollection();
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Allergen::class)]
    private Collection $allergens;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getUserRecipes(): Collection
    {
        return $this->userRecipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->userRecipes->contains($recipe)) {
            $this->userRecipes->add($recipe);
            $recipe->setUserRecipe($this);
     * @return Collection<int, Allergen>
     */
    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergen $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
            $allergen->setUser($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->userRecipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getUserRecipe() === $this) {
                $recipe->setUserRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getFavoritesRecipes(): Collection
    {
        return $this->favoritesRecipes;
    }

    public function addFavoritesRecipe(Recipe $favoritesRecipe): static
    {
        if (!$this->favoritesRecipes->contains($favoritesRecipe)) {
            $this->favoritesRecipes->add($favoritesRecipe);
            $favoritesRecipe->setFavoriteRecipe($this);
        }

        return $this;
    }

    public function removeFavoritesRecipe(Recipe $favoritesRecipe): static
    {
        if ($this->favoritesRecipes->removeElement($favoritesRecipe)) {
            // set the owning side to null (unless already changed)
            if ($favoritesRecipe->getFavoriteRecipe() === $this) {
                $favoritesRecipe->setFavoriteRecipe(null);
    public function removeAllergen(Allergen $allergen): static
    {
        if ($this->allergens->removeElement($allergen)) {
            // set the owning side to null (unless already changed)
            if ($allergen->getUser() === $this) {
                $allergen->setUser(null);
            }
        }

        return $this;
    }
}
