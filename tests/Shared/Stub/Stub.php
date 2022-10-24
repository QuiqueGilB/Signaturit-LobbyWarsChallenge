<?php

namespace Signaturit\LobbyWarsChallenge\Tests\Shared\Stub;

use ReflectionClass;

abstract class Stub
{
    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        // TODO: Clean and generate random values with detection types of properties by reflection
    }

    public function __call(string $name, array $arguments): static
    {
        str_starts_with('with', $name) && $this->magicWith($name, $arguments);
        return $this;
    }

    private function magicWith(string $name, array $arguments): static
    {
        $property = mb_strtolower($name[4]) . substr($name, 5);
        if (property_exists($this, $property)) {
            $this->{$property} = $arguments[0];
        }
        return $this;
    }

    public function stub()
    {
        $reflectionClass = new ReflectionClass(static::stubOf());
        $instance = $reflectionClass->newInstanceWithoutConstructor();
        foreach (get_object_vars($this) as $property => $value) {
            if ($reflectionClass->hasProperty($property)) {
                $property = $reflectionClass->getProperty($property);
                $property->setValue($instance, $value);
            }
        }
        $this->reset();
        return $instance;
    }

    abstract public static function stubOf(): string;
}
