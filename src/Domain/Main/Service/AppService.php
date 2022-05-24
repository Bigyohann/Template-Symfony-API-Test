<?php

namespace App\Domain\Main\Service;

use App\Exception\Api\ValidationException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AppService
{
    public SerializerInterface $serializer;
    public ValidatorInterface $validator;

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @param $class
     * @param $data
     * @param $object
     * @param null $groups
     * @return void
     * @throws ValidationException
     */
    public function validateAndPopulate($class, $data, $object, $groups = null): void
    {
        if (empty($data)) {
            throw new ValidationException('No body provided', []);
        }

        $data = $this->serializer->deserialize(
            $data,
            $class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $object, 'groups' => $groups]
        );

        $errors = $this->validator->validate($data, null, $groups);
        if (count($errors) > 0) {
            throw new ValidationException('Error from request', $errors);
        }
    }
}
