<?php
declare(strict_types = 1);

namespace AdminBundle\Form\DataTransformer;

use AppBundle\Entity\Region;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;
use Symfony\Component\PropertyAccess\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Tetranz\Select2EntityBundle\Form\DataTransformer\EntityToPropertyTransformer;

/**
 * AdminBundle\Form\DataTransformer\RegionEntitiesToPropertyTransformer
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class RegionEntitiesToPropertyTransformer extends EntityToPropertyTransformer
{
    /**
     * Transform entity to array
     *
     * @param Region|null $entity
     *
     * @return string
     * @throws UnexpectedTypeException
     * @throws InvalidArgumentException
     * @throws AccessException
     */
    public function transform($entity)
    {
        $data = [];
        if (null === $entity) {
            return $data;
        }
        $accessor = PropertyAccess::createPropertyAccessor();
        $text = sprintf('%s (%s)', $entity->getName(), $entity->getCountry()->getName());
        $data[$accessor->getValue($entity, $this->primaryKey)] = $text;

        return $data;
    }

    public function reverseTransform($value)
    {
        $repo = $this->em->getRepository($this->className);

        $entity = $repo->findOneBy([$this->textProperty => $value]);
        if (null !== $entity) {
            return $entity;
        }

        return parent::reverseTransform($value);
    }
}
