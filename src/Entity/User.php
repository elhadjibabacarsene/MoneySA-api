<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email", message="L'email existe déja !")
 * @UniqueEntity("telephone", message="Le téléphone existe déja !")
 * @ORM\Table(name="`user`")
 * @ApiResource(
 *     normalizationContext={"groups"={"users_read"}},
 *     denormalizationContext={"groups"={"users_write"}},
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "security"="is_granted('ROLE_SUPERADMIN') or is_granted('ROLE_ADMIN')",
 *              "securityMessage"="Vous n'avez pas accès à cette ressource"
 *           }
 *     },
 *     itemOperations={
 *          "get","delete",
 *          "put"={
 *              "security"="is_granted('USER_VIEW', object)",
 *              "securityMessage"="Vous n'avez pas accès à cette ressource",
 *              "deserialize"=false
 *          }
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_read", "compte_write", "compte_read", "transaction_write", "transaction_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Groups({"users_read", "users_write", "compte_write", "compte_read", "transaction_read"})
     */
    private $email;

    /**
     * Role de l'utilisateur
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"users_write", "compte_write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom est obligatoire")
     * @Groups({"users_read", "users_write", "compte_write", "compte_read", "transaction_read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire")
     * @Groups({"users_read", "users_write","compte_write"})
     * @Groups({"users_read", "users_write", "compte_write", "compte_read", "transaction_read"})
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"users_read", "users_write", "compte_write", "compte_read", "transaction_read"})
     */
    private $role;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"users_read", "users_write", "compte_write", "compte_read"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="users")
     * @Groups({"users_read", "users_write"})
     */
    private $agence;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"users_read", "users_write", "compte_write", "compte_read"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"users_read", "users_write", "compte_write", "compte_read"})
     */
    private $isFirstConnexion;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"users_read", "users_write", "compte_write", "compte_read"})
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups({"users_read", "users_write", "compte_write", "compte_read"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Compte::class, mappedBy="caissier")
     */
    private $compte;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="userDepot")
     */
    private $depotsTransactions;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="userRetrait")
     */
    private $retraitsTransactions;


    public function __construct()
    {
        $this->compte = new ArrayCollection();
        $this->isDeleted = false;
        $this->isActive = true;
        $this->isFirstConnexion = true;
        $this->depotsTransactions = new ArrayCollection();
        $this->retraitsTransactions = new ArrayCollection();
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
    public function getUsername(): string
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
        $roles[] = 'ROLE_' . strtoupper($this->getRole()->getLibelle());

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

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

    public function getIsFirstConnexion(): ?bool
    {
        return $this->isFirstConnexion;
    }

    public function setIsFirstConnexion(bool $isFirstConnexion): self
    {
        $this->isFirstConnexion = $isFirstConnexion;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->compte->contains($compte)) {
            $this->compte[] = $compte;
            $compte->setCaissier($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->compte->removeElement($compte)) {
            // set the owning side to null (unless already changed)
            if ($compte->getCaissier() === $this) {
                $compte->setCaissier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDepotsTransactions(): Collection
    {
        return $this->depotsTransactions;
    }

    public function addDepotsTransaction(Transaction $depotsTransaction): self
    {
        if (!$this->depotsTransactions->contains($depotsTransaction)) {
            $this->depotsTransactions[] = $depotsTransaction;
            $depotsTransaction->setUserDepot($this);
        }

        return $this;
    }

    public function removeDepotsTransaction(Transaction $depotsTransaction): self
    {
        if ($this->depotsTransactions->removeElement($depotsTransaction)) {
            // set the owning side to null (unless already changed)
            if ($depotsTransaction->getUserDepot() === $this) {
                $depotsTransaction->setUserDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getRetraitsTransactions(): Collection
    {
        return $this->retraitsTransactions;
    }

    public function addRetraitsTransaction(Transaction $retraitsTransaction): self
    {
        if (!$this->retraitsTransactions->contains($retraitsTransaction)) {
            $this->retraitsTransactions[] = $retraitsTransaction;
            $retraitsTransaction->setUserRetrait($this);
        }

        return $this;
    }

    public function removeRetraitsTransaction(Transaction $retraitsTransaction): self
    {
        if ($this->retraitsTransactions->removeElement($retraitsTransaction)) {
            // set the owning side to null (unless already changed)
            if ($retraitsTransaction->getUserRetrait() === $this) {
                $retraitsTransaction->setUserRetrait(null);
            }
        }

        return $this;
    }
}
