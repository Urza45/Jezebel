<?php

namespace App\Entity;

use App\Repository\SocietyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocietyRepository::class)
 */
class Society
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="society")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Admin::class, mappedBy="society")
     */
    private $admins;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="society")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Dossier::class, mappedBy="society")
     */
    private $dossiers;

    /**
     * @ORM\OneToMany(targetEntity=NormesAutorisees::class, mappedBy="society")
     */
    private $normesAutorisees;

    /**
     * @ORM\OneToMany(targetEntity=Candidat::class, mappedBy="society")
     */
    private $candidats;

    /**
     * @ORM\OneToOne(targetEntity=ParametersSociety::class, mappedBy="idSociety", cascade={"persist", "remove"})
     */
    private $parametersSociety;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->admins = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
        $this->normesAutorisees = new ArrayCollection();
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(?int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(?string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setSociety($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getSociety() === $this) {
                $contact->setSociety(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Admin>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(Admin $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
            $admin->setSociety($this);
        }

        return $this;
    }

    public function removeAdmin(Admin $admin): self
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getSociety() === $this) {
                $admin->setSociety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setSociety($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getSociety() === $this) {
                $client->setSociety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setSociety($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getSociety() === $this) {
                $dossier->setSociety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NormesAutorisees>
     */
    public function getNormesAutorisees(): Collection
    {
        return $this->normesAutorisees;
    }

    public function addNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if (!$this->normesAutorisees->contains($normesAutorisee)) {
            $this->normesAutorisees[] = $normesAutorisee;
            $normesAutorisee->setSociety($this);
        }

        return $this;
    }

    public function removeNormesAutorisee(NormesAutorisees $normesAutorisee): self
    {
        if ($this->normesAutorisees->removeElement($normesAutorisee)) {
            // set the owning side to null (unless already changed)
            if ($normesAutorisee->getSociety() === $this) {
                $normesAutorisee->setSociety(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setSociety($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->removeElement($candidat)) {
            // set the owning side to null (unless already changed)
            if ($candidat->getSociety() === $this) {
                $candidat->setSociety(null);
            }
        }

        return $this;
    }

    public function getParametersSociety(): ?ParametersSociety
    {
        return $this->parametersSociety;
    }

    public function setParametersSociety(?ParametersSociety $parametersSociety): self
    {
        // unset the owning side of the relation if necessary
        if ($parametersSociety === null && $this->parametersSociety !== null) {
            $this->parametersSociety->setIdSociety(null);
        }

        // set the owning side of the relation if necessary
        if ($parametersSociety !== null && $parametersSociety->getIdSociety() !== $this) {
            $parametersSociety->setIdSociety($this);
        }

        $this->parametersSociety = $parametersSociety;

        return $this;
    }
}
