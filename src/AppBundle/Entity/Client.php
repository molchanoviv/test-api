<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use OAuth2\OAuth2;

/**
 *  AppBundle\Entity\Client
 *
 * @ORM\Entity()
 * @ORM\Table(name="client")
 *
 * @author Ivan Molchanov <molchanoviv@yandex.ru>
 */
class Client extends BaseClient
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     *
     * @var User
     */
    protected $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->allowedGrantTypes = [
            OAuth2::GRANT_TYPE_IMPLICIT,
            OAuth2::GRANT_TYPE_AUTH_CODE,
            OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
            OAuth2::GRANT_TYPE_USER_CREDENTIALS
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Client
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Client
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param array $allowedGrantTypes
     *
     * @return Client
     */
    public function addAllowedGrantTypes(array $allowedGrantTypes)
    {
        $this->allowedGrantTypes = array_merge($this->allowedGrantTypes, $allowedGrantTypes);

        return $this;
    }
}
