<?php
declare(strict_types = 1);

namespace AppBundle\Normalizer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * AppResourceNormalizer.phpBundle\Normalizer\ArrayCollectionNormalizer
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class ArrayCollectionNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param ArrayCollection $object  object to normalize
     * @param string          $format  format the normalization result will be encoded as
     * @param array           $context Context options for the normalizer
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return $object->toArray();
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof ArrayCollection;
    }
}
