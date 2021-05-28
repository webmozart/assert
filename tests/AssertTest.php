<?php

/*
 * This file is part of the webmozart/assert package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Assert\Tests;

use ArrayIterator;
use ArrayObject;
use Error;
use Exception;
use LogicException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;
use Webmozart\Assert\Assert;

/**
 * @since  1.0
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class AssertTest extends TestCase
{
    private static $resource;

    public static function getResource()
    {
        if (!static::$resource) {
            static::$resource = fopen(__FILE__, 'r');
        }

        return static::$resource;
    }

    /**
     * @afterClass
     */
    public static function doTearDownAfterClass()
    {
        @fclose(self::$resource);
    }

    public function getTests()
    {
        $resource = self::getResource();

        return array(
            array('string', array('value'), true),
            array('string', array(''), true),
            array('string', array(1234), false),
            array('stringNotEmpty', array('value'), true),
            array('stringNotEmpty', array('0'), true),
            array('stringNotEmpty', array(''), false),
            array('stringNotEmpty', array(1234), false),
            array('integer', array(123), true),
            array('integer', array('123'), false),
            array('integer', array(1.0), false),
            array('integer', array(1.23), false),
            array('integerish', array(1.0), true),
            array('integerish', array(1.23), false),
            array('integerish', array(123), true),
            array('integerish', array('123'), true),
            array('positiveInteger', array(123), true),
            array('positiveInteger', array(1), true),
            array('positiveInteger', array(-123), false),
            array('positiveInteger', array(0), false),
            array('positiveInteger', array(0.0), false),
            array('positiveInteger', array('123'), false),
            array('positiveInteger', array('-123'), false),
            array('positiveInteger', array('0'), false),
            array('positiveInteger', array(1.0), false),
            array('positiveInteger', array(1.23), false),
            array('float', array(1.0), true),
            array('float', array(1.23), true),
            array('float', array(123), false),
            array('float', array('123'), false),
            array('numeric', array(1.0), true),
            array('numeric', array(1.23), true),
            array('numeric', array(123), true),
            array('numeric', array('123'), true),
            array('numeric', array('foo'), false),
            array('natural', array(0), true),
            array('natural', array(1), true),
            array('natural', array(-1), false),
            array('natural', array('1'), false),
            array('natural', array(1.0), false),
            array('natural', array(1.23), false),
            array('boolean', array(true), true),
            array('boolean', array(false), true),
            array('boolean', array(1), false),
            array('boolean', array('1'), false),
            array('scalar', array('1'), true),
            array('scalar', array(123), true),
            array('scalar', array(true), true),
            array('scalar', array(null), false),
            array('scalar', array(array()), false),
            array('scalar', array(new stdClass()), false),
            array('object', array(new stdClass()), true),
            array('object', array(new RuntimeException()), true),
            array('object', array(null), false),
            array('object', array(true), false),
            array('object', array(1), false),
            array('object', array(array()), false),
            array('resource', array($resource), true),
            array('resource', array($resource, 'stream'), true),
            array('resource', array($resource, 'other'), false),
            array('resource', array(1), false),
            array('isCallable', array('strlen'), true),
            array('isCallable', array(array($this, 'getTests')), true),
            array('isCallable', array(function () {}), true),
            array('isCallable', array(1234), false),
            array('isCallable', array('foobar'), false),
            array('isArray', array(array()), true),
            array('isArray', array(array(1, 2, 3)), true),
            array('isArray', array(new ArrayIterator(array())), false),
            array('isArray', array(123), false),
            array('isArray', array(new stdClass()), false),
            array('isTraversable', array(array()), true),
            array('isTraversable', array(array(1, 2, 3)), true),
            array('isTraversable', array(new ArrayIterator(array())), true),
            array('isTraversable', array(123), false),
            array('isTraversable', array(new stdClass()), false),
            array('isArrayAccessible', array(array()), true),
            array('isArrayAccessible', array(array(1, 2, 3)), true),
            array('isArrayAccessible', array(new ArrayObject(array())), true),
            array('isArrayAccessible', array(123), false),
            array('isArrayAccessible', array(new stdClass()), false),
            array('isCountable', array(array()), true),
            array('isCountable', array(array(1, 2)), true),
            array('isCountable', array(new ArrayIterator(array())), true),
            array('isCountable', array(new stdClass()), false),
            array('isCountable', array(new \SimpleXMLElement('<foo>bar</foo>')), true),
            array('isCountable', array('abcd'), false),
            array('isCountable', array(123), false),
            array('isIterable', array(array()), true),
            array('isIterable', array(array(1, 2, 3)), true),
            array('isIterable', array(new ArrayIterator(array())), true),
            array('isIterable', array(123), false),
            array('isIterable', array(new stdClass()), false),
            array('isInstanceOf', array(new stdClass(), 'stdClass'), true),
            array('isInstanceOf', array(new Exception(), 'stdClass'), false),
            array('isInstanceOf', array(123, 'stdClass'), false),
            array('isInstanceOf', array(array(), 'stdClass'), false),
            array('isInstanceOf', array(null, 'stdClass'), false),
            array('notInstanceOf', array(new stdClass(), 'stdClass'), false),
            array('notInstanceOf', array(new Exception(), 'stdClass'), true),
            array('notInstanceOf', array(123, 'stdClass'), true),
            array('notInstanceOf', array(array(), 'stdClass'), true),
            array('isInstanceOfAny', array(new ArrayIterator(), array('Iterator', 'ArrayAccess')), true),
            array('isInstanceOfAny', array(new Exception(), array('Exception', 'Countable')), true),
            array('isInstanceOfAny', array(new Exception(), array('ArrayAccess', 'Countable')), false),
            array('isInstanceOfAny', array(123, array('stdClass')), false),
            array('isInstanceOfAny', array(array(), array('stdClass')), false),
            array('isAOf', array('stdClass', 'stdClass'), true),
            array('isAOf', array('stdClass', 123), false),
            array('isAOf', array('Iterator', 'ArrayIterator'), false),
            array('isAOf', array(123, 'Iterator'), false),
            array('isAOf', array(array(), 'Iterator'), false),
            array('isAnyOf', array('ArrayIterator', array('Iterator', 'ArrayAccess')), true),
            array('isAnyOf', array('ArrayIterator', array(123)), false),
            array('isAnyOf', array('Exception', array('Exception', 'Countable')), true),
            array('isAnyOf', array('Exception', array('ArrayAccess', 'Countable')), false),
            array('isAnyOf', array(123, array('stdClass')), false),
            array('isAnyOf', array(array(), array('stdClass')), false),
            array('isNotA', array('stdClass', 'stdClass'), false),
            array('isNotA', array('stdClass', 123), false),
            array('isNotA', array('Iterator', 'ArrayIterator'), true),
            array('isNotA', array(123, 'Iterator'), true),
            array('isNotA', array(array(), 'Iterator'), true),
            array('true', array(true), true),
            array('true', array(false), false),
            array('true', array(1), false),
            array('true', array(null), false),
            array('false', array(false), true),
            array('false', array(true), false),
            array('false', array(1), false),
            array('false', array(0), false),
            array('false', array(null), false),
            array('notFalse', array(false), false),
            array('notFalse', array(true), true),
            array('notFalse', array(1), true),
            array('notFalse', array(0), true),
            array('notFalse', array(null), true),
            array('null', array(null), true),
            array('null', array(false), false),
            array('null', array(0), false),
            array('notNull', array(false), true),
            array('notNull', array(0), true),
            array('notNull', array(null), false),
            array('isEmpty', array(null), true),
            array('isEmpty', array(false), true),
            array('isEmpty', array(0), true),
            array('isEmpty', array(''), true),
            array('isEmpty', array(1), false),
            array('isEmpty', array('a'), false),
            array('notEmpty', array(1), true),
            array('notEmpty', array('a'), true),
            array('notEmpty', array(null), false),
            array('notEmpty', array(false), false),
            array('notEmpty', array(0), false),
            array('notEmpty', array(''), false),
            array('eq', array(1, 1), true),
            array('eq', array(1, '1'), true),
            array('eq', array(1, true), true),
            array('eq', array(1, 0), false),
            array('notEq', array(1, 0), true),
            array('notEq', array(1, 1), false),
            array('notEq', array(1, '1'), false),
            array('notEq', array(1, true), false),
            array('same', array(1, 1), true),
            array('same', array(1, '1'), false),
            array('same', array(1, true), false),
            array('same', array(1, 0), false),
            array('notSame', array(1, 0), true),
            array('notSame', array(1, 1), false),
            array('notSame', array(1, '1'), true),
            array('notSame', array(1, true), true),
            array('greaterThan', array(1, 0), true),
            array('greaterThan', array(0, 0), false),
            array('greaterThanEq', array(2, 1), true),
            array('greaterThanEq', array(1, 1), true),
            array('greaterThanEq', array(0, 1), false),
            array('lessThan', array(0, 1), true),
            array('lessThan', array(1, 1), false),
            array('lessThanEq', array(0, 1), true),
            array('lessThanEq', array(1, 1), true),
            array('lessThanEq', array(2, 1), false),
            array('range', array(1, 1, 2), true),
            array('range', array(2, 1, 2), true),
            array('range', array(0, 1, 2), false),
            array('range', array(3, 1, 2), false),
            array('implies', array(true, true), true),
            array('implies', array(true, false), false),
            array('implies', array(false, true), true),
            array('implies', array(false, false), true),
            array('oneOf', array(1, array(1, 2, 3)), true),
            array('oneOf', array(1, array('1', '2', '3')), false),
            array('inArray', array(1, array(1, 2, 3)), true),
            array('inArray', array(1, array('1', '2', '3')), false),
            array('contains', array('abcd', 'ab'), true),
            array('contains', array('abcd', 'bc'), true),
            array('contains', array('abcd', 'cd'), true),
            array('contains', array('abcd', 'de'), false),
            array('contains', array('', 'de'), false),
            array('contains', array('äþçð', 'äþ'), true),
            array('contains', array('äþçð', 'þç'), true),
            array('contains', array('äþçð', 'çð'), true),
            array('contains', array('äþçð', 'ðé'), false),
            array('contains', array('', 'ðé'), false),
            array('contains', array('あいうえ', 'あい'), true),
            array('contains', array('あいうえ', 'いう'), true),
            array('contains', array('あいうえ', 'うえ'), true),
            array('contains', array('あいうえ', 'えお'), false),
            array('contains', array('', 'えお'), false),
            array('contains', array('😄😑☹️', '😄'), true),
            array('contains', array('😄😑☹️', '😑'), true),
            array('contains', array('😄😑☹️', '☹️'), true),
            array('contains', array('😄😑☹️', '😄☹️'), false),
            array('contains', array('', '😑'), false),
            array('notContains', array('abcd', 'ab'), false),
            array('notContains', array('abcd', 'bc'), false),
            array('notContains', array('abcd', 'cd'), false),
            array('notContains', array('abcd', 'de'), true),
            array('notContains', array('', 'de'), true),
            array('notContains', array('äþçð', 'äþ'), false),
            array('notContains', array('äþçð', 'þç'), false),
            array('notContains', array('äþçð', 'çð'), false),
            array('notContains', array('äþçð', 'ðé'), true),
            array('notContains', array('', 'ðé'), true),
            array('notContains', array('あいうえ', 'あい'), false),
            array('notContains', array('あいうえ', 'いう'), false),
            array('notContains', array('あいうえ', 'うえ'), false),
            array('notContains', array('あいうえ', 'えお'), true),
            array('notContains', array('', 'えお'), true),
            array('notContains', array('😄😑☹️', '😄'), false),
            array('notContains', array('😄😑☹️', '😑'), false),
            array('notContains', array('😄😑☹️', '☹️'), false),
            array('notContains', array('😄😑☹️', '😄☹️'), true),
            array('notContains', array('', '😑'), true),
            array('notWhitespaceOnly', array('abc'), true),
            array('notWhitespaceOnly', array('123'), true),
            array('notWhitespaceOnly', array(' abc '), true),
            array('notWhitespaceOnly', array('a b c'), true),
            array('notWhitespaceOnly', array(''), false),
            array('notWhitespaceOnly', array(' '), false),
            array('notWhitespaceOnly', array("\t"), false),
            array('notWhitespaceOnly', array("\n"), false),
            array('notWhitespaceOnly', array("\r"), false),
            array('notWhitespaceOnly', array("\r\n\t "), false),
            array('startsWith', array('abcd', 'ab'), true),
            array('startsWith', array('abcd', 'bc'), false),
            array('startsWith', array('', 'bc'), false),
            array('startsWith', array('äþçð', 'äþ'), true),
            array('startsWith', array('äþçð', 'þç'), false),
            array('startsWith', array('', 'þç'), false),
            array('startsWith', array('あいうえ', 'あい'), true),
            array('startsWith', array('あいうえ', 'いう'), false),
            array('startsWith', array('', 'いう'), false),
            array('startsWith', array('😄😑☹️', '😄'), true),
            array('startsWith', array('😄😑☹️', '😑'), false),
            array('startsWith', array('', '😑'), false),
            array('startsWithLetter', array('abcd'), true),
            array('startsWithLetter', array(array(66)), false),
            array('startsWithLetter', array('a'), true),
            array('startsWithLetter', array('a1'), true),
            array('startsWithLetter', array('1abcd'), false),
            array('startsWithLetter', array('1'), false),
            array('startsWithLetter', array(''), false),
            array('startsWithLetter', array(null), false),
            array('startsWithLetter', array(66), false),
            array('notStartsWith', array('abcd', 'ab'), false),
            array('notStartsWith', array('abcd', 'bc'), true),
            array('notStartsWith', array('', 'bc'), true),
            array('notStartsWith', array('äþçð', 'äþ'), false),
            array('notStartsWith', array('äþçð', 'þç'), true),
            array('notStartsWith', array('', 'þç'), true),
            array('notStartsWith', array('あいうえ', 'あい'), false),
            array('notStartsWith', array('あいうえ', 'いう'), true),
            array('notStartsWith', array('', 'いう'), true),
            array('notStartsWith', array('😄😑☹️', '😄'), false),
            array('notStartsWith', array('😄😑☹️', '😑'), true),
            array('notStartsWith', array('', '😑'), true),
            array('endsWith', array('abcd', 'cd'), true),
            array('endsWith', array('abcd', 'bc'), false),
            array('endsWith', array('', 'bc'), false),
            array('endsWith', array('äþçð', 'çð'), true),
            array('endsWith', array('äþçð', 'þç'), false),
            array('endsWith', array('', 'þç'), false),
            array('endsWith', array('あいうえ', 'うえ'), true),
            array('endsWith', array('あいうえ', 'いう'), false),
            array('endsWith', array('', 'いう'), false),
            array('endsWith', array('😄😑☹️', '☹️'), true),
            array('endsWith', array('😄😑☹️', '😑'), false),
            array('endsWith', array('', '😑'), false),
            array('notEndsWith', array('abcd', 'cd'), false),
            array('notEndsWith', array('abcd', 'bc'), true),
            array('notEndsWith', array('', 'bc'), true),
            array('notEndsWith', array('äþçð', 'çð'), false),
            array('notEndsWith', array('äþçð', 'þç'), true),
            array('notEndsWith', array('', 'þç'), true),
            array('notEndsWith', array('あいうえ', 'うえ'), false),
            array('notEndsWith', array('あいうえ', 'いう'), true),
            array('notEndsWith', array('', 'いう'), true),
            array('notEndsWith', array('😄😑☹️', '☹️'), false),
            array('notEndsWith', array('😄😑☹️', '😑'), true),
            array('notEndsWith', array('', '😑'), true),
            array('regex', array('abcd', '~^ab~'), true),
            array('regex', array('abcd', '~^bc~'), false),
            array('regex', array('', '~^bc~'), false),
            array('notRegex', array('abcd', '{^ab}'), false),
            array('notRegex', array('abcd', '{^bc}'), true),
            array('notRegex', array('', '{^bc}'), true),
            array('unicodeLetters', array('abcd'), true),
            array('unicodeLetters', array('ᴁڅਘธブ乶'), true),
            array('unicodeLetters', array('ȁȄ'), true),
            array('unicodeLetters', array('ȁ1Ȅ'), false),
            array('unicodeLetters', array('©'), false),
            array('unicodeLetters', array('🙁'), false),
            array('unicodeLetters', array(''), false),
            array('alpha', array('abcd'), true),
            array('alpha', array('ab1cd'), false),
            array('alpha', array(''), false),
            array('alpha', array(66), false),
            array('alpha', array(array()), false),
            array('digits', array('1234'), true),
            array('digits', array('12a34'), false),
            array('digits', array(''), false),
            array('alnum', array('ab12'), true),
            array('alnum', array('ab12$'), false),
            array('alnum', array(''), false),
            array('lower', array('abcd'), true),
            array('lower', array('abCd'), false),
            array('lower', array('ab_d'), false),
            array('lower', array(''), false),
            array('upper', array('ABCD'), true),
            array('upper', array('ABcD'), false),
            array('upper', array('AB_D'), false),
            array('upper', array(''), false),
            array('length', array('abcd', 4), true),
            array('length', array('abc', 4), false),
            array('length', array('abcde', 4), false),
            array('length', array('äbcd', 4), true, true),
            array('length', array('äbc', 4), false, true),
            array('length', array('äbcde', 4), false, true),
            array('length', array('あbcd', 4), true, true), // 'HIRAGANA LETTER A' (U+3042)
            array('length', array('あbc', 4), false, true),
            array('length', array('あbcde', 4), false, true),
            array('minLength', array('abcd', 4), true),
            array('minLength', array('abcde', 4), true),
            array('minLength', array('abc', 4), false),
            array('minLength', array('äbcd', 4), true, true),
            array('minLength', array('äbcde', 4), true, true),
            array('minLength', array('äbc', 4), false, true),
            array('minLength', array('あbcd', 4), true, true),
            array('minLength', array('あbcde', 4), true, true),
            array('minLength', array('あbc', 4), false, true),
            array('maxLength', array('abcd', 4), true),
            array('maxLength', array('abc', 4), true),
            array('maxLength', array('abcde', 4), false),
            array('maxLength', array('äbcd', 4), true, true),
            array('maxLength', array('äbc', 4), true, true),
            array('maxLength', array('äbcde', 4), false, true),
            array('maxLength', array('あbcd', 4), true, true),
            array('maxLength', array('あbc', 4), true, true),
            array('maxLength', array('あbcde', 4), false, true),
            array('lengthBetween', array('abcd', 3, 5), true),
            array('lengthBetween', array('abc', 3, 5), true),
            array('lengthBetween', array('abcde', 3, 5), true),
            array('lengthBetween', array('ab', 3, 5), false),
            array('lengthBetween', array('abcdef', 3, 5), false),
            array('lengthBetween', array('äbcd', 3, 5), true, true),
            array('lengthBetween', array('äbc', 3, 5), true, true),
            array('lengthBetween', array('äbcde', 3, 5), true, true),
            array('lengthBetween', array('äb', 3, 5), false, true),
            array('lengthBetween', array('äbcdef', 3, 5), false, true),
            array('lengthBetween', array('あbcd', 3, 5), true, true),
            array('lengthBetween', array('あbc', 3, 5), true, true),
            array('lengthBetween', array('あbcde', 3, 5), true, true),
            array('lengthBetween', array('あb', 3, 5), false, true),
            array('lengthBetween', array('あbcdef', 3, 5), false, true),
            array('fileExists', array(__FILE__), true),
            array('fileExists', array(__DIR__), true),
            array('fileExists', array(__DIR__.'/foobar'), false),
            array('file', array(__FILE__), true),
            array('file', array(__DIR__), false),
            array('file', array(__DIR__.'/foobar'), false),
            array('directory', array(__DIR__), true),
            array('directory', array(__FILE__), false),
            array('directory', array(__DIR__.'/foobar'), false),
            // no tests for readable()/writable() for now
            array('classExists', array(__CLASS__), true),
            array('classExists', array(__NAMESPACE__.'\Foobar'), false),
            array('subclassOf', array(__CLASS__, 'PHPUnit\Framework\TestCase'), true),
            array('subclassOf', array(__CLASS__, 'stdClass'), false),
            array('interfaceExists', array('\Countable'), true),
            array('interfaceExists', array(__CLASS__), false),
            array('implementsInterface', array('ArrayIterator', 'Traversable'), true),
            array('implementsInterface', array(__CLASS__, 'Traversable'), false),
            array('propertyExists', array((object) array('property' => 0), 'property'), true),
            array('propertyExists', array((object) array('property' => null), 'property'), true),
            array('propertyExists', array((object) array('property' => null), 'foo'), false),
            array('propertyNotExists', array((object) array('property' => 0), 'property'), false),
            array('propertyNotExists', array((object) array('property' => null), 'property'), false),
            array('propertyNotExists', array((object) array('property' => null), 'foo'), true),
            array('methodExists', array('RuntimeException', 'getMessage'), true),
            array('methodExists', array(new RuntimeException(), 'getMessage'), true),
            array('methodExists', array('stdClass', 'getMessage'), false),
            array('methodExists', array(new stdClass(), 'getMessage'), false),
            array('methodExists', array(null, 'getMessage'), false),
            array('methodExists', array(true, 'getMessage'), false),
            array('methodExists', array(1, 'getMessage'), false),
            array('methodNotExists', array('RuntimeException', 'getMessage'), false),
            array('methodNotExists', array(new RuntimeException(), 'getMessage'), false),
            array('methodNotExists', array('stdClass', 'getMessage'), true),
            array('methodNotExists', array(new stdClass(), 'getMessage'), true),
            array('methodNotExists', array(null, 'getMessage'), true),
            array('methodNotExists', array(true, 'getMessage'), true),
            array('methodNotExists', array(1, 'getMessage'), true),
            array('keyExists', array(array('key' => 0), 'key'), true),
            array('keyExists', array(array('key' => null), 'key'), true),
            array('keyExists', array(array('key' => null), 'foo'), false),
            array('keyNotExists', array(array('key' => 0), 'key'), false),
            array('keyNotExists', array(array('key' => null), 'key'), false),
            array('keyNotExists', array(array('key' => null), 'foo'), true),
            array('validArrayKey', array('abcd'), true),
            array('validArrayKey', array(1), true),
            array('validArrayKey', array(false), false),
            array('validArrayKey', array(true), false),
            array('validArrayKey', array(new stdClass()), false),
            array('validArrayKey', array(new ToStringClass('testString')), false),
            array('validArrayKey', array(self::getResource()), false),
            array('count', array(array(0, 1, 2), 3), true),
            array('count', array(array(0, 1, 2), 2), false),
            array('minCount', array(array(0), 2), false),
            array('minCount', array(array(0, 1), 2), true),
            array('minCount', array(array(0, 1, 2), 2), true),
            array('maxCount', array(array(0, 1, 2), 2), false),
            array('maxCount', array(array(0, 1), 2), true),
            array('maxCount', array(array(0), 2), true),
            array('countBetween', array(array(0, 1, 2), 4, 5), false),
            array('countBetween', array(array(0, 1, 2), 3, 5), true),
            array('countBetween', array(array(0, 1, 2), 1, 2), false),
            array('countBetween', array(array(0, 1, 2), 2, 5), true),
            array('countBetween', array(array(0, 1, 2), 2, 3), true),
            array('isList', array(array(1, 2, 3)), true),
            array('isList', array(array()), true),
            array('isList', array(array(0 => 1, 2 => 3)), false),
            array('isList', array(array('key' => 1, 'foo' => 2)), false),
            array('isList', array(true), false),
            array('isList', array(false), false),
            array('isList', array(array(true)), true),
            array('isList', array(array(false)), true),
            array('isList', array(array(array(1), array(2))), true),
            array('isList', array(array(array('foo' => 'bar'), array('baz' => 'tab'))), true),
            array('isNonEmptyList', array(array(1, 2, 3)), true),
            array('isNonEmptyList', array(array()), false),
            array('isNonEmptyList', array(array(0 => 1, 2 => 3)), false),
            array('isNonEmptyList', array(array('key' => 1, 'foo' => 2)), false),
            array('isNonEmptyList', array(true), false),
            array('isNonEmptyList', array(false), false),
            array('isNonEmptyList', array(array(true)), true),
            array('isNonEmptyList', array(array(false)), true),
            array('isNonEmptyList', array(array(array(1), array(2))), true),
            array('isNonEmptyList', array(array(array('foo' => 'bar'), array('baz' => 'tab'))), true),
            array('isMap', array(array('key' => 1, 'foo' => 2)), true),
            array('isMap', array(array()), true),
            array('isMap', array(array(1, 2, 3)), false),
            array('isMap', array(array(0 => 1, 2 => 3)), false),
            array('isNonEmptyMap', array(array('key' => 1, 'foo' => 2)), true),
            array('isNonEmptyMap', array(array()), false),
            array('isNonEmptyMap', array(array(1, 2, 3)), false),
            array('isNonEmptyMap', array(array(0 => 1, 2 => 3)), false),
            array('uuid', array('00000000-0000-0000-0000-000000000000'), true),
            array('uuid', array('urn:ff6f8cb0-c57d-21e1-9b21-0800200c9a66'), true),
            array('uuid', array('uuid:{ff6f8cb0-c57d-21e1-9b21-0800200c9a66}'), true),
            array('uuid', array('ff6f8cb0-c57d-21e1-9b21-0800200c9a66'), true),
            array('uuid', array('ff6f8cb0-c57d-11e1-9b21-0800200c9a66'), true),
            array('uuid', array('ff6f8cb0-c57d-31e1-9b21-0800200c9a66'), true),
            array('uuid', array('ff6f8cb0-c57d-41e1-9b21-0800200c9a66'), true),
            array('uuid', array('ff6f8cb0-c57d-51e1-9b21-0800200c9a66'), true),
            array('uuid', array('FF6F8CB0-C57D-11E1-9B21-0800200C9A66'), true),
            array('uuid', array('zf6f8cb0-c57d-11e1-9b21-0800200c9a66'), false),
            array('uuid', array('af6f8cb0c57d11e19b210800200c9a66'), false),
            array('uuid', array('ff6f8cb0-c57da-51e1-9b21-0800200c9a66'), false),
            array('uuid', array('af6f8cb-c57d-11e1-9b21-0800200c9a66'), false),
            array('uuid', array('3f6f8cb0-c57d-11e1-9b21-0800200c9a6'), false),
            array('throws', array(function () { throw new LogicException('test'); }, 'LogicException'), true),
            array('throws', array(function () { throw new LogicException('test'); }, 'IllogicException'), false),
            array('throws', array(function () { throw new Exception('test'); }), true),
            array('throws', array(function () { trigger_error('test'); }, 'Throwable'), true, false, 70000),
            array('throws', array(function () { trigger_error('test'); }, 'Unthrowable'), false, false, 70000),
            array('throws', array(function () { throw new Error(); }, 'Throwable'), true, true, 70000),
            array('ip', array('192.168.0.1'), true),
            array('ip', array(new ToStringClass('192.168.0.1')), true),
            array('ip', array('255.255.255.255'), true),
            array('ip', array('0.0.0.0'), true),
            array('ip', array('2001:0db8:0000:0042:0000:8a2e:0370:7334'), true),
            array('ip', array('::ffff:192.0.2.1'), true),
            array('ip', array('::1'), true),
            array('ip', array('::'), true),
            array('ip', array('foo'), false),
            array('ip', array(123), false),
            array('ip', array(array()), false),
            array('ip', array(null), false),
            array('ip', array(false), false),
            array('ipv4', array('192.168.0.1'), true),
            array('ipv4', array(new ToStringClass('192.168.0.1')), true),
            array('ipv4', array('255.255.255.255'), true),
            array('ipv4', array('0.0.0.0'), true),
            array('ipv4', array('2001:0db8:0000:0042:0000:8a2e:0370:7334'), false),
            array('ipv4', array('::ffff:192.0.2.1'), false),
            array('ipv4', array('::1'), false),
            array('ipv4', array('::'), false),
            array('ipv4', array('foo'), false),
            array('ipv4', array(123), false),
            array('ipv4', array(array()), false),
            array('ipv4', array(null), false),
            array('ipv4', array(false), false),
            array('ipv6', array('192.168.0.1'), false),
            array('ipv6', array('255.255.255.255'), false),
            array('ipv6', array('0.0.0.0'), false),
            array('ipv6', array('2001:0db8:0000:0042:0000:8a2e:0370:7334'), true),
            array('ipv6', array(new ToStringClass('2001:0db8:0000:0042:0000:8a2e:0370:7334')), true),
            array('ipv6', array('::ffff:192.0.2.1'), true),
            array('ipv6', array('::1'), true),
            array('ipv6', array('::'), true),
            array('ipv6', array('foo'),  false),
            array('ipv6', array(123), false),
            array('ipv6', array(array()), false),
            array('ipv6', array(null), false),
            array('ipv6', array(false), false),
            array('email', array('foo'), false),
            array('email', array(123), false),
            array('email', array('foo.com'), false),
            array('email', array('foo@bar.com'), true),
            array('email', array(new ToStringClass('foo@bar.com')), true),
            array('uniqueValues', array(array('qwerty', 'qwerty')), false),
            array('uniqueValues', array(array('asdfg', 'qwerty')), true),
            array('uniqueValues', array(array(123, '123')), false),
        );
    }

    public function getMethods()
    {
        $methods = array();

        foreach ($this->getTests() as $params) {
            $methods[$params[0]] = array($params[0]);
        }

        return array_values($methods);
    }

    /**
     * @dataProvider getTests
     */
    public function testAssert($method, $args, $success, $multibyte = false, $minVersion = null)
    {
        if ($minVersion && PHP_VERSION_ID < $minVersion) {
            $this->markTestSkipped(sprintf('This test requires php %s or upper.', $minVersion));

            return;
        }
        if ($multibyte && !function_exists('mb_strlen')) {
            $this->markTestSkipped('The function mb_strlen() is not available');
        }

        if (!$success) {
            $this->expectException('\InvalidArgumentException');
        }

        call_user_func_array(array('Webmozart\Assert\Assert', $method), $args);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider getTests
     */
    public function testNullOr($method, $args, $success, $multibyte = false, $minVersion = null)
    {
        if ($minVersion && PHP_VERSION_ID < $minVersion) {
            $this->markTestSkipped(sprintf('This test requires php %s or upper.', $minVersion));

            return;
        }
        if ($multibyte && !function_exists('mb_strlen')) {
            $this->markTestSkipped('The function mb_strlen() is not available');
        }

        if (!$success && null !== reset($args)) {
            $this->expectException('\InvalidArgumentException');
        }

        call_user_func_array(array('Webmozart\Assert\Assert', 'nullOr'.ucfirst($method)), $args);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider getMethods
     */
    public function testNullOrAcceptsNull($method)
    {
        call_user_func(array('Webmozart\Assert\Assert', 'nullOr'.ucfirst($method)), null, null, null);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider getTests
     */
    public function testAllArray($method, $args, $success, $multibyte = false, $minVersion = null)
    {
        if ($minVersion && PHP_VERSION_ID < $minVersion) {
            $this->markTestSkipped(sprintf('This test requires php %s or upper.', $minVersion));

            return;
        }
        if ($multibyte && !function_exists('mb_strlen')) {
            $this->markTestSkipped('The function mb_strlen() is not available');
        }

        if (!$success) {
            $this->expectException('\InvalidArgumentException');
        }

        $arg = array_shift($args);
        array_unshift($args, array($arg));

        call_user_func_array(array('Webmozart\Assert\Assert', 'all'.ucfirst($method)), $args);
        $this->addToAssertionCount(1);
    }

    /**
     * @dataProvider getTests
     */
    public function testAllTraversable($method, $args, $success, $multibyte = false, $minVersion = null)
    {
        if ($minVersion && PHP_VERSION_ID < $minVersion) {
            $this->markTestSkipped(sprintf('This test requires php %s or upper.', $minVersion));

            return;
        }
        if ($multibyte && !function_exists('mb_strlen')) {
            $this->markTestSkipped('The function mb_strlen() is not available');
        }

        if (!$success) {
            $this->expectException('\InvalidArgumentException');
        }

        $arg = array_shift($args);
        array_unshift($args, new ArrayIterator(array($arg)));

        call_user_func_array(array('Webmozart\Assert\Assert', 'all'.ucfirst($method)), $args);
        $this->addToAssertionCount(1);
    }

    public function getStringConversions()
    {
        return array(
            array('integer', array('foobar'), 'Expected an integer. Got: string'),
            array('string', array(1), 'Expected a string. Got: integer'),
            array('string', array(true), 'Expected a string. Got: boolean'),
            array('string', array(null), 'Expected a string. Got: NULL'),
            array('string', array(array()), 'Expected a string. Got: array'),
            array('string', array(new stdClass()), 'Expected a string. Got: stdClass'),
            array('string', array(self::getResource()), 'Expected a string. Got: resource'),

            array('eq', array('1', '2'), 'Expected a value equal to "2". Got: "1"'),
            array('eq', array(new ToStringClass('XXX'), new ToStringClass('YYY')), 'Expected a value equal to Webmozart\Assert\Tests\ToStringClass: "YYY". Got: Webmozart\Assert\Tests\ToStringClass: "XXX"'),
            array('eq', array(1, 2), 'Expected a value equal to 2. Got: 1'),
            array('eq', array(true, false), 'Expected a value equal to false. Got: true'),
            array('eq', array(true, null), 'Expected a value equal to null. Got: true'),
            array('eq', array(null, true), 'Expected a value equal to true. Got: null'),
            array('eq', array(array(1), array(2)), 'Expected a value equal to array. Got: array'),
            array('eq', array(new ArrayIterator(array()), new stdClass()), 'Expected a value equal to stdClass. Got: ArrayIterator'),
            array('eq', array(1, self::getResource()), 'Expected a value equal to resource. Got: 1'),

            array('lessThan', array(new \DateTime('2020-01-01 00:00:00'), new \DateTime('1999-01-01 00:00:00')), 'Expected a value less than DateTime: "1999-01-01T00:00:00+00:00". Got: DateTime: "2020-01-01T00:00:00+00:00"'),
        );
    }

    /**
     * @dataProvider getStringConversions
     */
    public function testConvertValuesToStrings($method, $args, $exceptionMessage)
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage($exceptionMessage);

        call_user_func_array(array('Webmozart\Assert\Assert', $method), $args);
    }

    public function testAnUnknownMethodThrowsABadMethodCall()
    {
        $this->expectException('\BadMethodCallException');

        Assert::nonExistentMethod();
    }

    public function getInvalidIsAOfCases(): iterable
    {
        yield array(
            array('stdClass', 123),
            'Expected class as a string. Got: integer',
        );

        yield array(
            array('Iterator', 'ArrayIterator'),
            'Expected an instance of this class or to this class among its parents "ArrayIterator". Got: "Iterator"',
        );

        yield array(
            array(123, 'Iterator'),
            'Expected an instance of this class or to this class among its parents "Iterator". Got: 123',
        );

        yield array(
            array(array(), 'Iterator'),
            'Expected an instance of this class or to this class among its parents "Iterator". Got: array',
        );

        yield array(
            array(new \stdClass(), 'Iterator'),
            'Expected an instance of this class or to this class among its parents "Iterator". Got: stdClass',
        );
    }

    /**
     * @dataProvider getInvalidIsAOfCases
     */
    public function testIsAOfExceptionMessages(array $args, string $exceptionMessage): void
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage($exceptionMessage);

        call_user_func_array(array('Webmozart\Assert\Assert', 'isAOf'), $args);
    }
}

/**
 * @ignore
 */
class ToStringClass
{
    /**
     * @var string
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
