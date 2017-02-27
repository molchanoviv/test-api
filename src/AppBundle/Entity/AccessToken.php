<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;
use Doctrine\ORM\Mapping as ORM;

/**
 *  AppBundle\Entity\AccessToken
 *
 * @ORM\Entity()
 * @ORM\Table(name="access_token")
 *
 * @author Ivan Molchanov <molchanoviv@yandex.ru>
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var Client
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     *
     * @var User
     */
    protected $user;
}
