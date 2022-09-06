<?php

namespace App\Http\Utils\Dto;

use ReflectionException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Dto
{
    /**
     * @throws ReflectionException
     * @throws HttpException
     */
    public function transformToObject(object $object): void
    {
        $reflection = new \ReflectionClass(static::class);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $reflectionProperty = new \ReflectionProperty(static::class, $property->getName());
            if (!$reflectionProperty->isInitialized($this)) {
                continue;
            }
            $setFunctionName = 'set'.ucfirst($property->name);
            if ( method_exists($object::class, $setFunctionName) !== true) {
                throw new HttpException(500, 'exception');
            }
            if ($this->{$property->name}){
                $object->$setFunctionName($this->{$property->name});
            }
        }
    }
}