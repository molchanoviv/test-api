<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use AppBundle\Manager\AbstractManager;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use Doctrine\Instantiator\Instantiator;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Knp\Component\Pager\Paginator;
use LogicException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Serializer;

/**
 * AppBundle\Controller\Controller
 *
 * @author Ivan Molchanov <molchanoviv@xakep.ru>
 */
abstract class Controller extends FOSRestController implements ClassResourceInterface
{
    use ManagersControllerTrait;

    /**
     * @param object $entity
     * @param string $method
     *
     * @return mixed
     * @throws ExceptionInterface
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws BadRequestHttpException
     * @throws LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @throws UnexpectedValueException
     */
    protected function processForm($entity, $method = Request::METHOD_POST)
    {
        $form = $this->createForm($this->getResourceFormType(), $entity, ['method' => $method]);
        $form->handleRequest($this->getCurrentRequest());
        if (!$form->isSubmitted() || !$form->isValid()) {
            throw new BadRequestHttpException(json_encode($this->getFormErrors($form)));
        }
        $this->getResourceManager()->persist($entity);
        $this->getResourceManager()->flush();

        return $entity;
    }

    /**
     * @return null|Request
     * @throws ExceptionInterface
     * @throws LogicException
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function getCurrentRequest()
    {
        $request = $this->get('request_stack')->getCurrentRequest();
        /** @var FormType $form */
        $form = $this->getInstantiator()->instantiate($this->getResourceFormType());
        $formName = $form->getBlockPrefix();
        if ('' !== $request->getContent()) {
            $content[$formName] = json_decode($request->getContent(), true);
            $request->request->replace($content);
        }

        return $request;
    }

    /**
     * @param FormInterface $form
     *
     * @return string
     */
    protected function getFormErrors(FormInterface $form)
    {
        $errors = [];

        foreach ($form->getErrors() as $error) {
            $errors[] = [
                'error' => $error->getMessage(),
                'property' => $form->getName(),
            ];
        }

        foreach ($form->all() as $childForm) {
            if ($childErrors = $this->getFormErrors($childForm)) {
                foreach ($childErrors as $childError) {
                    $errors[] = $childError;
                }
            }
        }

        return $errors;
    }

    /**
     * @return AbstractManager
     */
    abstract public function getResourceManager();

    /**
     * @return string
     */
    abstract public function getResourceFormType(): string;

    /**
     * @return Instantiator
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     */
    protected function getInstantiator()
    {
        return $this->get('doctrine.instantiator');
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

    /**
     * @return Serializer
     */
    protected function getSerializer()
    {
        return $this->get('serializer');
    }
}
