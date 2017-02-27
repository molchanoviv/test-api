<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AppBundle\Entity\City
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CityRepository")
 * @ORM\Table(name="city", uniqueConstraints={@ORM\UniqueConstraint(name="IDX_CITY_IN_REGION", columns={"name", "region_id"})})
 * @UniqueEntity(fields={"name", "region"}, message="City with this name already exists in region")
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class City
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
     * @var Region
     *
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Region", inversedBy="cities", cascade={"persist"})
     */
    protected $region;

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
     * @return City
     */
    public function setId($id): City
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
     * @return City
     */
    public function setName($name): City
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Region
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     *
     * @return City
     */
    public function setRegion($region): City
    {
        $this->region = $region;
        if (null !== $region && false === $region->hasCity($this)) {
            $region->addCity($this);
        }

        return $this;
    }
}
