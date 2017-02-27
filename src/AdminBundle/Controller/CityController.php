<?php
declare(strict_types = 1);

namespace AdminBundle\Controller;

use AdminBundle\Form\Type\CityType;
use AppBundle\Controller\ManagersControllerTrait;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * AdminBundle\Controller\CityController
 *
 * @Route("/admin/city")
 * @Security("has_role('ROLE_ADMIN')")
 *
 * @author Ivan Molchanov <molchanoviv@yandex.ru>
 */
class CityController extends Controller
{
    use ManagersControllerTrait;

    /**
     * @Route("/list/{page}", name="app_city_list", defaults={"page"="1"})
     *
     * @param $page
     *
     * @return array|Response
     * @throws \Exception
     */
    public function listAction($page)
    {
        /** @var SlidingPagination $entities */
        $cities = $this->getPaginator()->paginate(
            $this->getCityManager()->getCitiesQuery(),
            $page,
            100
        );

        return $this->render(':admin/city:list.html.twig', ['cities' => $cities]);
    }

    /**
     * @Route("/show/{id}", name="app_city_show", requirements={"id": "\d+"})
     * @param integer $id
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws InvalidArgumentException
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Twig_Error
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \UnexpectedValueException
     */
    public function showAction($id)
    {
        $manager = $this->getCityManager();
        $entity = $manager->find($id);
        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        return $this->render(':admin/city:show.html.twig', ['entity' => $entity]);
    }

    /**
     * @Route("/new", name="app_city_new")
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     * @throws \LogicException
     * @throws \Twig_Error
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \UnexpectedValueException
     */
    public function createAction(Request $request)
    {
        $manager = $this->getCityManager();
        $entity = $manager->createNew();

        $form = $this->createForm(CityType::class, $entity, ['method' => 'POST']);

        if ($form->handleRequest($request)->isValid()) {
            $manager->save($entity);

            return $this->redirect($this->generateUrl('app_city_list'));
        }

        return $this->render(':admin/city:new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_city_edit", requirements={"id": "\d+"})
     * @param Request $request
     *
     * @param int     $id
     *
     * @return RedirectResponse|Response
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     * @throws \LogicException
     * @throws \Twig_Error
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \UnexpectedValueException
     */
    public function editAction(Request $request, $id)
    {
        $manager = $this->getCityManager();
        $entity = $manager->find($id);
        if (null === $entity) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(CityType::class, $entity, ['method' => 'POST']);

        if ($form->handleRequest($request)->isValid()) {
            $manager->save($entity);

            return $this->redirect($this->generateUrl('app_city_list'));
        }

        return $this->render(':admin/city:edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/remove/{id}", name="app_city_remove", requirements={"id": "\d+"})
     * @param integer $id
     *
     * @return Response
     * @throws AccessDeniedException
     * @throws NotFoundHttpException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws \Exception
     * @throws \LogicException
     */
    public function removeAction($id)
    {
        $manager = $this->getCityManager();

        $entity = $manager->find($id);
        if (null === $entity) {
            throw new NotFoundHttpException();
        }
        $manager->remove($entity);
        $manager->flush();

        return $this->redirect($this->generateUrl('app_city_list'));
    }

    /**
     * @return Paginator
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function getPaginator()
    {
        return $this->get('knp_paginator');
    }
}
