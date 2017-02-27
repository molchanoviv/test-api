<?php
declare(strict_types = 1);

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AdminBundle\Controller\DefaultController
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('nelmio_api_doc_index');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        return $this->redirectToRoute('app_city_list');
    }
}
