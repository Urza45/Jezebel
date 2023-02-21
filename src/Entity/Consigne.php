<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consigne
 *
 * @ORM\Table(name="consigne",                                      indexes={@ORM\Index(name="id_theme", columns={"id_theme"})})
 * @ORM\Entity(repositoryClass="App\Repository\ConsigneRepository")
 */
class Consigne
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
     * @ORM\Column(name="point", type="integer", nullable=false)
     */
    private $point;

    /**
     * @var string|null
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @var \Theme
     *
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_theme",     referencedColumnName="id")
     * })
     */
    private $idTheme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getIdTheme(): ?Theme
    {
        return $this->idTheme;
    }

    public function setIdTheme(?Theme $idTheme): self
    {
        $this->idTheme = $idTheme;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabel();
    }
}
