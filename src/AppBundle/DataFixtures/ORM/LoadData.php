<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Controller\ManagersControllerTrait;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Intl\Intl;

/**
 * AppBundle\DataFixtures\ORM\LoadData
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class LoadData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    use ManagersControllerTrait;

    /**
     * @var array
     */
    private static $countries = [
        ['code' => 'en_AU', 'regionProperty' => 'state'],
        ['code' => 'en_CA', 'regionProperty' => 'province'],
        ['code' => 'zh_CN', 'regionProperty' => 'state'],
        ['code' => 'fi_FI', 'regionProperty' => 'state'],
        ['code' => 'fr_FR', 'regionProperty' => 'region'],
        ['code' => 'de_DE', 'regionProperty' => 'state'],
        ['code' => 'ru_RU', 'regionProperty' => 'region'],
        ['code' => 'en_US', 'regionProperty' => 'state'],
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $countryManager = $this->getCountryManager();
        $regionManager = $this->getRegionManager();
        $regionBundle = Intl::getRegionBundle();
        foreach (self::$countries as $countryArr) {
            $code = $countryArr['code'];
            list($languageCode, $countryCode) = explode('_', $code);
            $countryName = $regionBundle->getCountryName($countryCode, $languageCode);
            $regionProperty = $countryArr['regionProperty'];
            $country = $countryManager->createCountry($countryName, $code);
            $countryManager->persist($country);
            $providerClass = sprintf('Faker\Provider\%s\Address', $code);
            $faker = new Generator();
            $faker->addProvider(new $providerClass($faker));
            for ($i = 0; $i < 15; $i++) {
                try {
                    $regionName = $faker->unique()->$regionProperty;
                } catch (\OverflowException $e) {
                    break; //If fake does not have enough regions just ignore it.
                }
                $region = $regionManager->createRegion($regionName, $country);
                $regionManager->persist($region);
            }
        }
        $countryManager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
