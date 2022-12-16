<?php
namespace Tmoorlag\PhpTypedArrays;

use ArrayIterator;

class TypedArray extends ArrayIterator {
     public function __construct(Array $songs = [])
    {        
        parent::__construct(new ArrayIterator($this->createTypedArray($this->className, $songs)));
    }

    // create a function that turns array keys to camelcase
    public function arrayKeysToCamelCase(array $array) : array
    {
        $camelCaseArray = [];
        foreach($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $camelCaseArray[$camelCaseKey] = $value;
        }
        return $camelCaseArray;
    }

    /**
     * IN PHP create a function that takes a class-name and an array of arrays. Use reflection on the class-name to determine each property of the class and its type and if its nullable or not. Now build an array of objects based on the class and use record of the array data to populate the property values based on the array key. If they array key does not exists or its value is null and the matched property is not nullable then throw an exception 'Array Data Mismatch'
     * convert inner array keys to camelCase
     */
    public function createTypedArray(string $className, array $arrayData) : array
    {
        $reflectionClass = new \ReflectionClass($className);
        $properties = $reflectionClass->getProperties();
        $typedArray = [];

        foreach($arrayData as $arrayItem) {
            $object = $reflectionClass->newInstanceWithoutConstructor();
            foreach($properties as $property) {
                $propertyName = $property->getName();
                $propertyType = $property->getType();
                $propertyType = $propertyType ? $propertyType->getName() : null;
                $propertyIsNullable = $property->getType()->allowsNull();

                $arrayItem = $this->arrayKeysToCamelCase($arrayItem);
                if (array_key_exists($propertyName, $arrayItem)) {
                    $propertyValue = $arrayItem[$propertyName];
                    if ($propertyValue === null && !$propertyIsNullable) {
                        throw new \Exception('Array Data Mismatch');
                    }
                    $object->$propertyName = $propertyValue;
                } else if (!$propertyIsNullable) {
                    throw new \Exception('Array Data Mismatch');
                }
            }
            $typedArray[] = $object;
        }
        return $typedArray;
    }
}