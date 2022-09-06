<?php

namespace App\Http\Utils\ParamConverter;

use App\Exception\Api\ValidationException;
use App\Http\Utils\Dto\Dto;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DtoParamConverter implements ParamConverterInterface
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly ValidatorInterface $validator)
    {
    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        if ($request->getContentType() !== 'json') {
            return false;
        }

        $data = $request->getContent();
        if (empty($data)) {
            throw new ValidationException('No body provided', []);
        }
        $objectDto = new ($configuration->getClass())();
        $data = $this->serializer->deserialize(
            $data,
            $configuration->getClass(),
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $objectDto]
        );

        $errors = $this->validator->validate($data);
        if (count($errors) > 0) {
            throw new ValidationException('Error from request', $errors);
        }
        $request->attributes->set($configuration->getName(), $objectDto);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function supports(ParamConverter $configuration): bool
    {
        return is_subclass_of($configuration->getClass(), Dto::class);
    }
}