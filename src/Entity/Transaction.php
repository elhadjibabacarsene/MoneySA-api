<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *     routePrefix="/user",
 *     normalizationContext={"groups"={"transaction_read"}},
 *     denormalizationContext={"groups"={"transaction_write"}},
 *     collectionOperations={
 *          "post"
 *     }
 * )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction_read"})
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction_read"})
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="string", length=9)
     * @Groups({"transaction_read"})
     */
    private $codeTransfert;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $frais;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_read"})
     */
    private $montantAvecFrais;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_read"})
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_read"})
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_read"})
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_read"})
     */
    private $fraisSysteme;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depotsTransactions")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $userDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="retraitsTransactions")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $userRetrait;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="clientDepotTransactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $clientDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="clientRetraitTransactions")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $clientRetrait;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getCodeTransfert(): ?string
    {
        return $this->codeTransfert;
    }

    public function setCodeTransfert(string $codeTransfert): self
    {
        $this->codeTransfert = $codeTransfert;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getMontantAvecFrais(): ?int
    {
        return $this->montantAvecFrais;
    }

    public function setMontantAvecFrais(int $montantAvecFrais): self
    {
        $this->montantAvecFrais = $montantAvecFrais;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(int $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(int $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSysteme(): ?int
    {
        return $this->fraisSysteme;
    }

    public function setFraisSysteme(int $fraisSysteme): self
    {
        $this->fraisSysteme = $fraisSysteme;

        return $this;
    }

    public function getUserDepot(): ?User
    {
        return $this->userDepot;
    }

    public function setUserDepot(?User $userDepot): self
    {
        $this->userDepot = $userDepot;

        return $this;
    }

    public function getUserRetrait(): ?User
    {
        return $this->userRetrait;
    }

    public function setUserRetrait(?User $userRetrait): self
    {
        $this->userRetrait = $userRetrait;

        return $this;
    }

    public function getClientDepot(): ?Client
    {
        return $this->clientDepot;
    }

    public function setClientDepot(?Client $clientDepot): self
    {
        $this->clientDepot = $clientDepot;

        return $this;
    }

    public function getClientRetrait(): ?Client
    {
        return $this->clientRetrait;
    }

    public function setClientRetrait(?Client $clientRetrait): self
    {
        $this->clientRetrait = $clientRetrait;

        return $this;
    }
}
