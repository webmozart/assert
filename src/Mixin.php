<?php

namespace Webmozart\Assert;

use ArrayAccess;
use Closure;
use Countable;
use Throwable;

/**
 * This trait provides nurllOr* and all* variants of assertion base methods.
 * Do not use this trait directly: it will change, and is not designed for reuse.
 */
trait Mixin
{
    /**
     * @psalm-pure
     * @psalm-assert string|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrString($value, $message = '')
    {
        null === $value || static::string($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<string> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allString($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::string($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert non-empty-string|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrStringNotEmpty($value, $message = '')
    {
        null === $value || static::stringNotEmpty($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<non-empty-string> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allStringNotEmpty($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::stringNotEmpty($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert int|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrInteger($value, $message = '')
    {
        null === $value || static::integer($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<int> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allInteger($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::integer($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert numeric|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIntegerish($value, $message = '')
    {
        null === $value || static::integerish($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<numeric> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIntegerish($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::integerish($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert positive-int|null $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrPositiveInteger($value, $message = '')
    {
        null === $value || static::positiveInteger($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<positive-int> $value
     *
     * @param mixed  $value
     * @param string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allPositiveInteger($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::positiveInteger($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert float|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrFloat($value, $message = '')
    {
        null === $value || static::float($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<float> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allFloat($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::float($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert numeric|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNumeric($value, $message = '')
    {
        null === $value || static::numeric($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<numeric> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNumeric($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::numeric($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert positive-int|0|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNatural($value, $message = '')
    {
        null === $value || static::natural($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<positive-int|0> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNatural($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::natural($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert bool|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrBoolean($value, $message = '')
    {
        null === $value || static::boolean($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<bool> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allBoolean($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::boolean($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert scalar|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrScalar($value, $message = '')
    {
        null === $value || static::scalar($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<scalar> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allScalar($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::scalar($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert object|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrObject($value, $message = '')
    {
        null === $value || static::object($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<object> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allObject($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::object($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert resource|null $value
     *
     * @param mixed       $value
     * @param string|null $type    type of resource this should be. @see https://www.php.net/manual/en/function.get-resource-type.php
     * @param string      $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrResource($value, $type = null, $message = '')
    {
        null === $value || static::resource($value, $type, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<resource> $value
     *
     * @param mixed       $value
     * @param string|null $type    type of resource this should be. @see https://www.php.net/manual/en/function.get-resource-type.php
     * @param string      $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allResource($value, $type = null, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::resource($entry, $type, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert callable|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsCallable($value, $message = '')
    {
        null === $value || static::isCallable($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<callable> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsCallable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isCallable($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsArray($value, $message = '')
    {
        null === $value || static::isArray($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<array> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsArray($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isArray($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable|null $value
     *
     * @deprecated use "isIterable" or "isInstanceOf" instead
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsTraversable($value, $message = '')
    {
        null === $value || static::isTraversable($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<iterable> $value
     *
     * @deprecated use "isIterable" or "isInstanceOf" instead
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsTraversable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isTraversable($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array|ArrayAccess|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsArrayAccessible($value, $message = '')
    {
        null === $value || static::isArrayAccessible($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<array|ArrayAccess> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsArrayAccessible($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isArrayAccessible($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert countable|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsCountable($value, $message = '')
    {
        null === $value || static::isCountable($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<countable> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsCountable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isCountable($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsIterable($value, $message = '')
    {
        null === $value || static::isIterable($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<iterable> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsIterable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isIterable($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType|null $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsInstanceOf($value, $class, $message = '')
    {
        null === $value || static::isInstanceOf($value, $class, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert iterable<ExpectedType> $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsInstanceOf($value, $class, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isInstanceOf($entry, $class, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotInstanceOf($value, $class, $message = '')
    {
        null === $value || static::notInstanceOf($value, $class, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotInstanceOf($value, $class, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notInstanceOf($entry, $class, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param mixed                $value
     * @param array<object|string> $classes
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsInstanceOfAny($value, $classes, $message = '')
    {
        null === $value || static::isInstanceOfAny($value, $classes, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param mixed                $value
     * @param array<object|string> $classes
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsInstanceOfAny($value, $classes, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isInstanceOfAny($entry, $classes, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert ExpectedType|class-string<ExpectedType>|null $value
     *
     * @param object|string|null $value
     * @param string             $class
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsAOf($value, $class, $message = '')
    {
        null === $value || static::isAOf($value, $class, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert iterable<ExpectedType|class-string<ExpectedType>> $value
     *
     * @param iterable<object|string> $value
     * @param string                  $class
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsAOf($value, $class, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isAOf($entry, $class, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template UnexpectedType of object
     * @psalm-param class-string<UnexpectedType> $class
     *
     * @param object|string|null $value
     * @param string             $class
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsNotA($value, $class, $message = '')
    {
        null === $value || static::isNotA($value, $class, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template UnexpectedType of object
     * @psalm-param class-string<UnexpectedType> $class
     *
     * @param iterable<object|string> $value
     * @param string                  $class
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsNotA($value, $class, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isNotA($entry, $class, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param object|string|null $value
     * @param string[]           $classes
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsAnyOf($value, $classes, $message = '')
    {
        null === $value || static::isAnyOf($value, $classes, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param array<class-string> $classes
     *
     * @param iterable<object|string> $value
     * @param string[]                $classes
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsAnyOf($value, $classes, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isAnyOf($entry, $classes, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert empty $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsEmpty($value, $message = '')
    {
        null === $value || static::isEmpty($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<empty> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsEmpty($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::isEmpty($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotEmpty($value, $message = '')
    {
        null === $value || static::notEmpty($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotEmpty($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notEmpty($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<null> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNull($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::null($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotNull($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notNull($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert true|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrTrue($value, $message = '')
    {
        null === $value || static::true($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<true> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allTrue($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::true($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert false|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrFalse($value, $message = '')
    {
        null === $value || static::false($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<false> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allFalse($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::false($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotFalse($value, $message = '')
    {
        null === $value || static::notFalse($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotFalse($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notFalse($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIp($value, $message = '')
    {
        null === $value || static::ip($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIp($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::ip($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIpv4($value, $message = '')
    {
        null === $value || static::ipv4($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIpv4($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::ipv4($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIpv6($value, $message = '')
    {
        null === $value || static::ipv6($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIpv6($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::ipv6($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrEmail($value, $message = '')
    {
        null === $value || static::email($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allEmail($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::email($entry, $message);
        }
    }

    /**
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrUniqueValues($values, $message = '')
    {
        null === $values || static::uniqueValues($values, $message);
    }

    /**
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allUniqueValues($values, $message = '')
    {
        static::isIterable($values);

        foreach ($values as $entry) {
            static::uniqueValues($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrEq($value, $expect, $message = '')
    {
        null === $value || static::eq($value, $expect, $message);
    }

    /**
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allEq($value, $expect, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::eq($entry, $expect, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotEq($value, $expect, $message = '')
    {
        null === $value || static::notEq($value, $expect, $message);
    }

    /**
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotEq($value, $expect, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notEq($entry, $expect, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrSame($value, $expect, $message = '')
    {
        null === $value || static::same($value, $expect, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allSame($value, $expect, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::same($entry, $expect, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotSame($value, $expect, $message = '')
    {
        null === $value || static::notSame($value, $expect, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $expect
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotSame($value, $expect, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notSame($entry, $expect, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrGreaterThan($value, $limit, $message = '')
    {
        null === $value || static::greaterThan($value, $limit, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allGreaterThan($value, $limit, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::greaterThan($entry, $limit, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrGreaterThanEq($value, $limit, $message = '')
    {
        null === $value || static::greaterThanEq($value, $limit, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allGreaterThanEq($value, $limit, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::greaterThanEq($entry, $limit, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrLessThan($value, $limit, $message = '')
    {
        null === $value || static::lessThan($value, $limit, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allLessThan($value, $limit, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::lessThan($entry, $limit, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrLessThanEq($value, $limit, $message = '')
    {
        null === $value || static::lessThanEq($value, $limit, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $limit
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allLessThanEq($value, $limit, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::lessThanEq($entry, $limit, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $min
     * @param mixed                    $max
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrRange($value, $min, $max, $message = '')
    {
        null === $value || static::range($value, $min, $max, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param mixed                    $min
     * @param mixed                    $max
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allRange($value, $min, $max, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::range($entry, $min, $max, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param array                    $values
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrOneOf($value, $values, $message = '')
    {
        null === $value || static::oneOf($value, $values, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param array                    $values
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allOneOf($value, $values, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::oneOf($entry, $values, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param array                    $values
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrInArray($value, $values, $message = '')
    {
        null === $value || static::inArray($value, $values, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param array                    $values
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allInArray($value, $values, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::inArray($entry, $values, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $subString
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrContains($value, $subString, $message = '')
    {
        null === $value || static::contains($value, $subString, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $subString
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allContains($value, $subString, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::contains($entry, $subString, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $subString
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotContains($value, $subString, $message = '')
    {
        null === $value || static::notContains($value, $subString, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $subString
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotContains($value, $subString, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notContains($entry, $subString, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotWhitespaceOnly($value, $message = '')
    {
        null === $value || static::notWhitespaceOnly($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotWhitespaceOnly($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notWhitespaceOnly($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $prefix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrStartsWith($value, $prefix, $message = '')
    {
        null === $value || static::startsWith($value, $prefix, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $prefix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allStartsWith($value, $prefix, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::startsWith($entry, $prefix, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $prefix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotStartsWith($value, $prefix, $message = '')
    {
        null === $value || static::notStartsWith($value, $prefix, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $prefix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotStartsWith($value, $prefix, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notStartsWith($entry, $prefix, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrStartsWithLetter($value, $message = '')
    {
        null === $value || static::startsWithLetter($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allStartsWithLetter($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::startsWithLetter($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $suffix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrEndsWith($value, $suffix, $message = '')
    {
        null === $value || static::endsWith($value, $suffix, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $suffix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allEndsWith($value, $suffix, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::endsWith($entry, $suffix, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $suffix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotEndsWith($value, $suffix, $message = '')
    {
        null === $value || static::notEndsWith($value, $suffix, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $suffix
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotEndsWith($value, $suffix, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notEndsWith($entry, $suffix, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $pattern
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrRegex($value, $pattern, $message = '')
    {
        null === $value || static::regex($value, $pattern, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $pattern
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allRegex($value, $pattern, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::regex($entry, $pattern, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string                   $pattern
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrNotRegex($value, $pattern, $message = '')
    {
        null === $value || static::notRegex($value, $pattern, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string                   $pattern
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allNotRegex($value, $pattern, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::notRegex($entry, $pattern, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrUnicodeLetters($value, $message = '')
    {
        null === $value || static::unicodeLetters($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allUnicodeLetters($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::unicodeLetters($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrAlpha($value, $message = '')
    {
        null === $value || static::alpha($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allAlpha($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::alpha($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrDigits($value, $message = '')
    {
        null === $value || static::digits($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allDigits($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::digits($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrAlnum($value, $message = '')
    {
        null === $value || static::alnum($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allAlnum($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::alnum($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert lowercase-string|null $value
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrLower($value, $message = '')
    {
        null === $value || static::lower($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<lowercase-string> $value
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allLower($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::lower($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrUpper($value, $message = '')
    {
        null === $value || static::upper($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allUpper($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::upper($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param int                      $length
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrLength($value, $length, $message = '')
    {
        null === $value || static::length($value, $length, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param int                      $length
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allLength($value, $length, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::length($entry, $length, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null $value
     * @param int|float   $min
     * @param string      $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMinLength($value, $min, $message = '')
    {
        null === $value || static::minLength($value, $min, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string> $value
     * @param int|float        $min
     * @param string           $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMinLength($value, $min, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::minLength($entry, $min, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null $value
     * @param int|float   $max
     * @param string      $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMaxLength($value, $max, $message = '')
    {
        null === $value || static::maxLength($value, $max, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string> $value
     * @param int|float        $max
     * @param string           $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMaxLength($value, $max, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::maxLength($entry, $max, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null $value
     * @param int|float   $min
     * @param int|float   $max
     * @param string      $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrLengthBetween($value, $min, $max, $message = '')
    {
        null === $value || static::lengthBetween($value, $min, $max, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string> $value
     * @param int|float        $min
     * @param int|float        $max
     * @param string           $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allLengthBetween($value, $min, $max, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::lengthBetween($entry, $min, $max, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrFileExists($value, $message = '')
    {
        null === $value || static::fileExists($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allFileExists($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::fileExists($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrFile($value, $message = '')
    {
        null === $value || static::file($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allFile($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::file($entry, $message);
        }
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrDirectory($value, $message = '')
    {
        null === $value || static::directory($value, $message);
    }

    /**
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allDirectory($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::directory($entry, $message);
        }
    }

    /**
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrReadable($value, $message = '')
    {
        null === $value || static::readable($value, $message);
    }

    /**
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allReadable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::readable($entry, $message);
        }
    }

    /**
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrWritable($value, $message = '')
    {
        null === $value || static::writable($value, $message);
    }

    /**
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allWritable($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::writable($entry, $message);
        }
    }

    /**
     * @psalm-assert class-string|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrClassExists($value, $message = '')
    {
        null === $value || static::classExists($value, $message);
    }

    /**
     * @psalm-assert iterable<class-string> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allClassExists($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::classExists($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert class-string<ExpectedType>|ExpectedType|null $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrSubclassOf($value, $class, $message = '')
    {
        null === $value || static::subclassOf($value, $class, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $class
     * @psalm-assert iterable<class-string<ExpectedType>|ExpectedType> $value
     *
     * @param mixed         $value
     * @param string|object $class
     * @param string        $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allSubclassOf($value, $class, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::subclassOf($entry, $class, $message);
        }
    }

    /**
     * @psalm-assert class-string|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrInterfaceExists($value, $message = '')
    {
        null === $value || static::interfaceExists($value, $message);
    }

    /**
     * @psalm-assert iterable<class-string> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allInterfaceExists($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::interfaceExists($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $interface
     * @psalm-assert class-string<ExpectedType>|null $value
     *
     * @param mixed                    $value
     * @param mixed                    $interface
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrImplementsInterface($value, $interface, $message = '')
    {
        null === $value || static::implementsInterface($value, $interface, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template ExpectedType of object
     * @psalm-param class-string<ExpectedType> $interface
     * @psalm-assert iterable<class-string<ExpectedType>> $value
     *
     * @param mixed                    $value
     * @param mixed                    $interface
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allImplementsInterface($value, $interface, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::implementsInterface($entry, $interface, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param class-string|object|null $classOrObject
     *
     * @param string|object|null $classOrObject
     * @param mixed              $property
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrPropertyExists($classOrObject, $property, $message = '')
    {
        null === $classOrObject || static::propertyExists($classOrObject, $property, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param iterable<class-string|object> $classOrObject
     *
     * @param iterable<string|object> $classOrObject
     * @param mixed                   $property
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allPropertyExists($classOrObject, $property, $message = '')
    {
        static::isIterable($classOrObject);

        foreach ($classOrObject as $entry) {
            static::propertyExists($entry, $property, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param class-string|object|null $classOrObject
     *
     * @param string|object|null $classOrObject
     * @param mixed              $property
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrPropertyNotExists($classOrObject, $property, $message = '')
    {
        null === $classOrObject || static::propertyNotExists($classOrObject, $property, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param iterable<class-string|object> $classOrObject
     *
     * @param iterable<string|object> $classOrObject
     * @param mixed                   $property
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allPropertyNotExists($classOrObject, $property, $message = '')
    {
        static::isIterable($classOrObject);

        foreach ($classOrObject as $entry) {
            static::propertyNotExists($entry, $property, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param class-string|object|null $classOrObject
     *
     * @param string|object|null $classOrObject
     * @param mixed              $method
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMethodExists($classOrObject, $method, $message = '')
    {
        null === $classOrObject || static::methodExists($classOrObject, $method, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param iterable<class-string|object> $classOrObject
     *
     * @param iterable<string|object> $classOrObject
     * @param mixed                   $method
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMethodExists($classOrObject, $method, $message = '')
    {
        static::isIterable($classOrObject);

        foreach ($classOrObject as $entry) {
            static::methodExists($entry, $method, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-param class-string|object|null $classOrObject
     *
     * @param string|object|null $classOrObject
     * @param mixed              $method
     * @param string             $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMethodNotExists($classOrObject, $method, $message = '')
    {
        null === $classOrObject || static::methodNotExists($classOrObject, $method, $message);
    }

    /**
     * @psalm-pure
     * @psalm-param iterable<class-string|object> $classOrObject
     *
     * @param iterable<string|object> $classOrObject
     * @param mixed                   $method
     * @param string                  $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMethodNotExists($classOrObject, $method, $message = '')
    {
        static::isIterable($classOrObject);

        foreach ($classOrObject as $entry) {
            static::methodNotExists($entry, $method, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param array|null $array
     * @param string|int $key
     * @param string     $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrKeyExists($array, $key, $message = '')
    {
        null === $array || static::keyExists($array, $key, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<array> $array
     * @param string|int      $key
     * @param string          $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allKeyExists($array, $key, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::keyExists($entry, $key, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param array|null $array
     * @param string|int $key
     * @param string     $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrKeyNotExists($array, $key, $message = '')
    {
        null === $array || static::keyNotExists($array, $key, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<array> $array
     * @param string|int      $key
     * @param string          $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allKeyNotExists($array, $key, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::keyNotExists($entry, $key, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert array-key|null $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrValidArrayKey($value, $message = '')
    {
        null === $value || static::validArrayKey($value, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<array-key> $value
     *
     * @param mixed                    $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allValidArrayKey($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::validArrayKey($entry, $message);
        }
    }

    /**
     * @param Countable|array|null $array
     * @param int                  $number
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrCount($array, $number, $message = '')
    {
        null === $array || static::count($array, $number, $message);
    }

    /**
     * @param iterable<Countable|array> $array
     * @param int                       $number
     * @param string                    $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allCount($array, $number, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::count($entry, $number, $message);
        }
    }

    /**
     * @param Countable|array|null $array
     * @param int|float            $min
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMinCount($array, $min, $message = '')
    {
        null === $array || static::minCount($array, $min, $message);
    }

    /**
     * @param iterable<Countable|array> $array
     * @param int|float                 $min
     * @param string                    $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMinCount($array, $min, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::minCount($entry, $min, $message);
        }
    }

    /**
     * @param Countable|array|null $array
     * @param int|float            $max
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrMaxCount($array, $max, $message = '')
    {
        null === $array || static::maxCount($array, $max, $message);
    }

    /**
     * @param iterable<Countable|array> $array
     * @param int|float                 $max
     * @param string                    $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allMaxCount($array, $max, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::maxCount($entry, $max, $message);
        }
    }

    /**
     * @param Countable|array|null $array
     * @param int|float            $min
     * @param int|float            $max
     * @param string               $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrCountBetween($array, $min, $max, $message = '')
    {
        null === $array || static::countBetween($array, $min, $max, $message);
    }

    /**
     * @param iterable<Countable|array> $array
     * @param int|float                 $min
     * @param int|float                 $max
     * @param string                    $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allCountBetween($array, $min, $max, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::countBetween($entry, $min, $max, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert list|null $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsList($array, $message = '')
    {
        null === $array || static::isList($array, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<list> $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsList($array, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::isList($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-assert non-empty-list|null $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsNonEmptyList($array, $message = '')
    {
        null === $array || static::isNonEmptyList($array, $message);
    }

    /**
     * @psalm-pure
     * @psalm-assert iterable<non-empty-list> $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsNonEmptyList($array, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::isNonEmptyList($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param mixed|array<T>|null $array
     * @psalm-assert array<string, T>|null $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsMap($array, $message = '')
    {
        null === $array || static::isMap($array, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param iterable<mixed|array<T>> $array
     * @psalm-assert iterable<array<string, T>> $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsMap($array, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::isMap($entry, $message);
        }
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param mixed|array<T>|null $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrIsNonEmptyMap($array, $message = '')
    {
        null === $array || static::isNonEmptyMap($array, $message);
    }

    /**
     * @psalm-pure
     * @psalm-template T
     * @psalm-param iterable<mixed|array<T>> $array
     *
     * @param mixed                    $array
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allIsNonEmptyMap($array, $message = '')
    {
        static::isIterable($array);

        foreach ($array as $entry) {
            static::isNonEmptyMap($entry, $message);
        }
    }

    /**
     * @psalm-pure
     *
     * @param string|null              $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrUuid($value, $message = '')
    {
        null === $value || static::uuid($value, $message);
    }

    /**
     * @psalm-pure
     *
     * @param iterable<string>         $value
     * @param string|callable():string $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allUuid($value, $message = '')
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::uuid($entry, $message);
        }
    }

    /**
     * @psalm-param class-string<Throwable> $class
     *
     * @param Closure|null $expression
     * @param string       $class
     * @param string       $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function nullOrThrows($expression, $class = 'Exception', $message = '')
    {
        null === $expression || static::throws($expression, $class, $message);
    }

    /**
     * @psalm-param class-string<Throwable> $class
     *
     * @param iterable<Closure> $expression
     * @param string            $class
     * @param string            $message
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public static function allThrows($expression, $class = 'Exception', $message = '')
    {
        static::isIterable($expression);

        foreach ($expression as $entry) {
            static::throws($entry, $class, $message);
        }
    }
}
