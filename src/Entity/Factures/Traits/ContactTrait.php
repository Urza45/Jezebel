<?php

namespace App\Entity\Factures\Traits;

use Doctrine\ORM\Mapping as ORM;

use function PHPUnit\Framework\isNull;

/**
 * Contact.
 *
 * @author Marc EYMARD <contact@marc-eymard.fr>
 */
trait ContactTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=80, nullable=false)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", nullable=false)
     */
    protected $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse2", type="string", nullable=true)
     */
    protected $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=false)
     */
    protected $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=30, nullable=false)
     */
    protected $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=50, nullable=true)
     */
    protected $telephone;

    /**
     * Set telephone.
     *
     * @param string $telephone
     *
     * @return this
     */
    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone.
     *
     * @return string
     */
    public function getTelephone(): string
    {
        if (isNull($this->telephone)) {
            $this->telephone = '';
        }
        return $this->telephone;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return this
     */
    public function setVille(string $ville)
    {
        $this->ville = $ville;

        return $this->ville;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille(): string
    {
        return $this->ville;
    }

    /**
     * Set code_postal.
     *
     * @param string $code_postal
     *
     * @return this
     */
    public function setCodePostal(string $codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get code_postal.
     *
     * @return string
     */
    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    /**
     * Set adresse2.
     *
     * @param string $adresse2
     *
     * @return this
     */
    public function setAdresse2(string $adresse2)
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    /**
     * Get adresse2.
     *
     * @return string
     */
    public function getAdresse2(): string
    {
        return $this->adresse2;
    }

    /**
     * Set adresse.
     *
     * @param string $adresse
     *
     * @return this
     */
    public function setAdresse(string $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse.
     *
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return this
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }
}
