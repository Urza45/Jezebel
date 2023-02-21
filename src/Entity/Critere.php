<?php

namespace App\Entity;

use App\Entity\Consigne;
use Doctrine\ORM\Mapping as ORM;

/**
 * Critere
 *
 * @ORM\Table(name="critere",                                      indexes={@ORM\Index(name="id_consigne", columns={"id_consigne"})})
 * @ORM\Entity(repositoryClass="App\Repository\CritereRepository")
 */
class Critere
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
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ptse1", type="integer", nullable=true)
     */
    private $ptse1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ptse2", type="integer", nullable=true)
     */
    private $ptse2;

    /**
     * @var \Consigne
     *
     * @ORM\ManyToOne(targetEntity="Consigne")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_consigne",     referencedColumnName="id")
     * })
     */
    private $idConsigne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPtse1(): ?int
    {
        return $this->ptse1;
    }

    public function setPtse1(?int $ptse1): self
    {
        $this->ptse1 = $ptse1;

        return $this;
    }

    public function getPtse2(): ?int
    {
        return $this->ptse2;
    }

    public function setPtse2(?int $ptse2): self
    {
        $this->ptse2 = $ptse2;

        return $this;
    }

    public function getIdConsigne(): ?Consigne
    {
        return $this->idConsigne;
    }

    public function setIdConsigne(?Consigne $idConsigne): self
    {
        $this->idConsigne = $idConsigne;

        return $this;
    }
}
