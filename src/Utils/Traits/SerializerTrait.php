<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 11.02.19
 * Time: 9:56
 */

namespace Sf4\Api\Utils\Traits;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait SerializerTrait
{

    /**
     * @param array|object|null $data
     */
    public function populate(array $data): void
    {
        $this->populateObject($data);
    }

    /**
     * @param array $data
     * @param null $object
     */
    public function populateObject(array $data, $object = null): void
    {
        if (null === $object) {
            $object = $this;
        }

        if (is_array($data)) {
            $json = json_encode($data);
            $class = get_class($object);
            $this->createSerializer()->deserialize($json, $class, 'json', [
                'object_to_populate' => $object
            ]);
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->objectToArray();
    }

    /**
     * @param null $object
     * @param array $ignoredAttributes
     * @return array
     */
    public function objectToArray($object = null, $ignoredAttributes = ['id', 'uuid']): array
    {
        if (null === $object) {
            $object = $this;
        } elseif (is_scalar($object)) {
            $object = [$object];
        }

        if (is_array($object)) {
            return $object;
        }

        try {
            $response = $this->createSerializer()->normalize($object, null, [
                ObjectNormalizer::ENABLE_MAX_DEPTH => true,
                ObjectNormalizer::IGNORED_ATTRIBUTES => $ignoredAttributes
            ]);
        } catch (ExceptionInterface $e) {
            $response = [];
        }

        return $response;
    }

    private function createSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        return new Serializer($normalizers, $encoders);
    }
}
