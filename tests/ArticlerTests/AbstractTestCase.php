<?php

namespace Kazan\ArticlerTests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

abstract class AbstractTestCase extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        date_default_timezone_set("UTC");
    }

    protected function setMethodAccessible($className, $methodName)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    protected function setPropertyValue($object, $property, $value)
    {
        $class = new ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    protected function getPropertyValue($object, $property)
    {
        $class = new ReflectionClass($object);
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}
