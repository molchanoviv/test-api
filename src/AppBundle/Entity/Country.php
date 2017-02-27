<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\Country
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CountryRepository")
 * @ORM\Table(name="country")
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class Country
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
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    protected $code;

    /**
     * @var ArrayCollection|Region[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Region", mappedBy="country", cascade={"persist"}, fetch="EXTRA_LAZY")
     */
    protected $regions;

    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->regions = new ArrayCollection();
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
     * @return Country
     */
    public function setId($id): Country
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
     * @return Country
     */
    public function setName($name): Country
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Country
     */
    public function setCode($code): Country
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return City[]|ArrayCollection|Collection
     */
    public function getRegions(): Collection
    {
        return $this->regions;
    }

    /**
     * @param City[]|ArrayCollection $regions
     *
     * @return Country
     */
    public function setRegions($regions): Country
    {
        $this->regions = $regions;

        return $this;
    }

    /**
     * @param Region $region
     *
     * @return Country
     */
    public function addRegion(Region $region): Country
    {
        $this->regions->add($region);
        if (null === $region->getCountry()) {
            $region->setCountry($this);
        }

        return $this;
    }

    /**
     * @param Region $region
     *
     * @return Country
     */
    public function removeRegion(Region $region): Country
    {
        $this->regions->removeElement($region);

        return $this;
    }

    /**
     * @param Region $region
     *
     * @return boolean
     */
    public function hasRegion(Region $region): bool
    {
        return $this->regions->contains($region);
    }
}
