<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Manager\CityManager;
use AppBundle\Manager\CountryManager;
use AppBundle\Manager\RegionManager;
use AppBundle\Manager\UserManager;
use Symfony\Component\DependencyInjection\Container;

/**
 * AppBundle\Controller\ManagersControllerTrait
 *
 * @property Container $container
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
trait ManagersControllerTrait
{
    /**
     * @return CountryManager
     * @throws \Exception
     */
    protected function getCountryManager()
    {
        return $this->container->get('app.manager.country_manager');
    }

    /**
     * @return RegionManager
     * @throws \Exception
     */
    protected function getRegionManager()
    {
        return $this->container->get('app.manager.region_manager');
    }

    /**
     * @return CityManager
     * @throws \Exception
     */
    protected function getCityManager()
    {
        return $this->container->get('app.manager.city_manager');
    }

    /**
     * @return UserManager
     * @throws \Exception
     */
    protected function getUserManager()
    {
        return $this->container->get('app.manager.user_manager');
    }
}
