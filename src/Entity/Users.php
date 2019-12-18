<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface as UUID;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Users implements UserInterface
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
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
    private $password;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $screenname;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=2, options={"fixed"=true})
     */
    private $language;

    
    /**
     * Flags
     */

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    
    /**
     * Tokens
     */

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activationToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passwordtoken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $passwordTokenExpiration;


    /**
     * Relationship
     */

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ads")
     * @ORM\JoinTable(name="favorites")
     */
    private $favorites;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medias", inversedBy="users")
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Addresses")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ads", mappedBy="createdBy", orphanRemoval=true)
     */
    private $ads;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offers", mappedBy="user", orphanRemoval=true)
     */
    private $offers;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->ads = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getId(): ?uuid
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

    public function getScreenname(): ?string
    {
        return $this->screenname;
    }

    /**
     * @ORM\PrePersist
     */
    public function setScreenname(): self
    {
        $this->screenname = $this->firstname;
        $this->screenname.= " ";
        $this->screenname.= substr($this->lastname, 0, 1).".";

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activationToken;
    }

    public function setActivationToken(?string $activationToken): self
    {
        $this->activationToken = $activationToken;

        return $this;
    }

    public function getPasswordtoken(): ?string
    {
        return $this->passwordtoken;
    }

    public function setPasswordtoken(?string $passwordtoken): self
    {
        $this->passwordtoken = $passwordtoken;

        return $this;
    }

    public function getPasswordTokenExpiration(): ?\DateTimeInterface
    {
        return $this->passwordTokenExpiration;
    }

    public function setPasswordTokenExpiration(?\DateTimeInterface $passwordTokenExpiration): self
    {
        $this->passwordTokenExpiration = $passwordTokenExpiration;

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ads $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setCreatedBy($this);
        }

        return $this;
    }

    public function removeAd(Ads $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getCreatedBy() === $this) {
                $ad->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ads[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Ads $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
        }

        return $this;
    }

    public function removeFavorite(Ads $favorite): self
    {
        if ($this->favorites->contains($favorite)) {
            $this->favorites->removeElement($favorite);
        }

        return $this;
    }

    /**
     * @return Collection|Offers[]
     */
    public function getOffers(): Collection
    {
        return $this->offers;
    }

    public function addOffer(Offers $offer): self
    {
        if (!$this->offers->contains($offer)) {
            $this->offers[] = $offer;
            $offer->setUser($this);
        }

        return $this;
    }

    public function removeOffer(Offers $offer): self
    {
        if ($this->offers->contains($offer)) {
            $this->offers->removeElement($offer);
            // set the owning side to null (unless already changed)
            if ($offer->getUser() === $this) {
                $offer->setUser(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?Medias
    {
        return $this->picture;
    }

    public function setPicture(?Medias $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): ?Addresses
    {
        return $this->address;
    }

    public function setAddress(?Addresses $address): self
    {
        $this->address = $address;

        return $this;
    }
}
