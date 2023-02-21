<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 *
 * @ORM\Table(name="theme",                                      indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"})})
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 */
class Theme
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
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer", nullable=false)
     */
    private $ordre = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="pts1", type="integer", nullable=true)
     */
    private $pts1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pts2", type="integer", nullable=true)
     */
    private $pts2;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_categorie",     referencedColumnName="id")
     * })
     */
    private $idCategorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
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

    public function getPts1(): ?int
    {
        return $this->pts1;
    }

    public function setPts1(?int $pts1): self
    {
        $this->pts1 = $pts1;

        return $this;
    }

    public function getPts2(): ?int
    {
        return $this->pts2;
    }

    public function setPts2(?int $pts2): self
    {
        $this->pts2 = $pts2;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
