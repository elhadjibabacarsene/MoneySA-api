<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"compte_read"}},
 *     denormalizationContext={"groups"={"compte_write"}},
 *     collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_SUPERADMIN')",
 *              "securityMessage"="Vous n'avez pas accès à cette ressource"
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_SUPERADMIN')",
 *              "securityMessage"="Vous n'avez pas accès à cette ressource"
 *          }
 *     },
 *     itemOperations={
 *          "get", "delete"
 *     }
 * )
 */
class Compte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"compte_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"compte_read"})
     */
    private $numero;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"compte_read"})
     */
    private $solde;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"compte_read"})
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=Agence::class, inversedBy="compte", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"compte_read", "compte_write"})
     */
    private $agence;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"compte_read"})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="compte")
     */
    private $caissier;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): self
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

    public function getCaissier(): ?User
    {
        return $this->caissier;
    }

    public function setCaissier(?User $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }
}
