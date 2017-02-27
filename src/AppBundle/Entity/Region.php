<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\Region
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RegionRepository")
 * @ORM\Table(name="region")
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var Country
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Country", inversedBy="regions", cascade={"persist"})
     */
    protected $country;

    /**
     * @var ArrayCollection|City[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\City", mappedBy="region", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    protected $cities;

    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Region
     */
    public function setId($id): Region
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Region
     */
    public function setName($name): Region
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return Region
     */
    public function setCountry($country): Region
    {
        $this->country = $country;
        if (null !== $country && false === $country->hasRegion($this)) {
            $country->addRegion($this);
        }

        return $this;
    }

    /**
     * @return City[]|ArrayCollection|Collection
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    /**
     * @param City[]|ArrayCollection $cities
     *
     * @return Region
     */
    public function setCities($cities): Region
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * @param City $city
     *
     * @return Region
     */
    public function addCity(City $city): Region
    {
        $this->cities->add($city);
        if (null === $city->getRegion()) {
            $city->setRegion($this);
        }

        return $this;
    }

    /**
     * @param City $city
     *
     * @return Region
     */
    public function removeCity(City $city): Region
    {
        $this->cities->removeElement($city);

        return $this;
    }

    /**
     * @param City $city
     *
     * @return boolean
     */
    public function hasCity(City $city): bool
    {
        return $this->cities->contains($city);
    }
}
