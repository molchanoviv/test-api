<?php
declare(strict_types = 1);

namespace AppBundle\Normalizer;

use AppBundle\Entity\City;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

/**
 * AppBundle\Normalizer\CityNormalizer
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
 */
class CityNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param City   $object  object to normalize
     * @param string $format  format the normalization result will be encoded as
     * @param array  $context Context options for the normalizer
     *
     * @return array
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'region' => $this->serializer->normalize(
                $object->getRegion(),
                $format,
                $context
            ),
            'country' => $this->serializer->normalize(
                $object->getRegion()->getCountry(),
                $format,
                $context
            ),
        ];
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
        return $data instanceof City;
    }
}
