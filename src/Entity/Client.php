<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_write", "transaction_read"})
     */
    private $numCNI;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="clientDepot")
     */
    private $clientDepotTransactions;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="clientRetrait")
     */
    private $clientRetraitTransactions;

    public function __construct()
    {
        $this->clientDepotTransactions = new ArrayCollection();
        $this->clientRetraitTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNumCNI(): ?int
    {
        return $this->numCNI;
    }

    public function setNumCNI(int $numCNI): self
    {
        $this->numCNI = $numCNI;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getClientDepotTransactions(): Collection
    {
        return $this->clientDepotTransactions;
    }

    public function addClientDepotTransaction(Transaction $clientDepotTransaction): self
    {
        if (!$this->clientDepotTransactions->contains($clientDepotTransaction)) {
            $this->clientDepotTransactions[] = $clientDepotTransaction;
            $clientDepotTransaction->setClientDepot($this);
        }

        return $this;
    }

    public function removeClientDepotTransaction(Transaction $clientDepotTransaction): self
    {
        if ($this->clientDepotTransactions->removeElement($clientDepotTransaction)) {
            // set the owning side to null (unless already changed)
            if ($clientDepotTransaction->getClientDepot() === $this) {
                $clientDepotTransaction->setClientDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getClientRetraitTransactions(): Collection
    {
        return $this->clientRetraitTransactions;
    }

    public function addClientRetraitTransaction(Transaction $clientRetraitTransaction): self
    {
        if (!$this->clientRetraitTransactions->contains($clientRetraitTransaction)) {
            $this->clientRetraitTransactions[] = $clientRetraitTransaction;
            $clientRetraitTransaction->setClientRetrait($this);
        }

        return $this;
    }

    public function removeClientRetraitTransaction(Transaction $clientRetraitTransaction): self
    {
        if ($this->clientRetraitTransactions->removeElement($clientRetraitTransaction)) {
            // set the owning side to null (unless already changed)
            if ($clientRetraitTransaction->getClientRetrait() === $this) {
                $clientRetraitTransaction->setClientRetrait(null);
            }
        }

        return $this;
    }
}
