<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="id",                   type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_client", type="string", length=50, nullable=false)
     */
    private $nomClient;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_client", type="string", length=255, nullable=false)
     */
    private $adresseClient;

    /**
     * @var int
     *
     * @ORM\Column(name="cp_client", type="integer", nullable=false)
     */
    private $cpClient;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_client", type="string", length=50, nullable=false)
     */
    private $villeClient = '';

    /**
     * @var string
     *
     * @ORM\Column(name="codeagence", type="string", nullable=false, options={"default"="78"})
     */
    private $codeagence;

    /**
     * @ORM\ManyToOne(targetEntity=Society::class, inversedBy="clients")
     */
    private $society;

    /**
     * @ORM\OneToMany(targetEntity=ContactClient::class, mappedBy="client")
     */
    private $contactClients;

    public function __construct()
    {
        $this->contactClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getCpClient(): ?int
    {
        return $this->cpClient;
    }

    public function setCpClient(int $cpClient): self
    {
        $this->cpClient = $cpClient;

        return $this;
    }

    public function getVilleClient(): ?string
    {
        return $this->villeClient;
    }

    public function setVilleClient(string $villeClient): self
    {
        $this->villeClient = $villeClient;

        return $this;
    }

    public function getCodeagence(): ?string
    {
        return $this->codeagence;
    }

    public function setCodeagence(string $codeagence): self
    {
        $this->codeagence = $codeagence;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomClient();
    }

    public function getSociety(): ?Society
    {
        return $this->society;
    }

    public function setSociety(?Society $society): self
    {
        $this->society = $society;

        return $this;
    }

    /**
     * @return Collection<int, ContactClient>
     */
    public function getContactClients(): Collection
    {
        return $this->contactClients;
    }

    public function addContactClient(ContactClient $contactClient): self
    {
        if (!$this->contactClients->contains($contactClient)) {
            $this->contactClients[] = $contactClient;
            $contactClient->setClient($this);
        }

        return $this;
    }

    public function removeContactClient(ContactClient $contactClient): self
    {
        if ($this->contactClients->removeElement($contactClient)) {
            // set the owning side to null (unless already changed)
            if ($contactClient->getClient() === $this) {
                $contactClient->setClient(null);
            }
        }

        return $this;
    }
}
