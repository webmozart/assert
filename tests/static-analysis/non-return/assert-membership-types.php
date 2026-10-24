<?php

declare(strict_types=1);

namespace Webmozart\Assert\Tests\StaticAnalysis\NonReturn;

use Traversable;
use Webmozart\Assert\Assert;

/**
 * @psalm-pure
 *
 * @return 'red'|'blue'
 */
function oneOfLiterals(mixed $value): string
{
    Assert::oneOf($value, ['red', 'blue']);

    return $value;
}

/**
 * @psalm-pure
 *
 * @return 1|2|'two'
 */
function inArrayMixedLiterals(mixed $value): int|string
{
    Assert::inArray($value, [1, 'two', 2]);

    return $value;
}

/**
 * @psalm-pure
 *
 * @return 1|2
 */
function oneOfArrayValues(mixed $value): int
{
    Assert::oneOf($value, ['first' => 1, 'second' => 2]);

    return $value;
}

/**
 * @psalm-pure
 *
 * @return 1
 */
function oneOfStrictIntAgainstFloat(int|float $value): int
{
    Assert::oneOf($value, [1]);

    return $value;
}

/**
 * @psalm-pure
 *
 * @return 'red'|'blue'
 */
function oneOfReorderedNamedArguments(string $candidate): string
{
    $allowed = ['red', 'blue'];
    $result = Assert::oneOf(values: $allowed, value: $candidate);
    /** @psalm-check-type-exact $candidate = 'red'|'blue' */
    /** @psalm-check-type-exact $result = 'red'|'blue' */

    return $result;
}

/**
 * @psalm-pure
 *
 * @param list<string> $candidate
 * @return list<'red'|'blue'>
 */
function oneOfReorderedNamedArgumentsWithArrayCandidate(array $candidate): array
{
    $allowed = [['red'], ['blue']];
    $result = Assert::oneOf(values: $allowed, value: $candidate);
    /** @psalm-check-type-exact $candidate = list{'red'|'blue'} */
    /** @psalm-check-type-exact $result = list{'red'|'blue'} */

    return $result;
}

/**
 * @psalm-pure
 *
 * @param list<mixed> $candidate
 * @return list<'red'|'blue'>
 */
function allOneOfReorderedNamedArguments(array $candidate): array
{
    $allowed = ['red', 'blue'];
    Assert::allOneOf(values: $allowed, value: $candidate);
    /** @psalm-check-type-exact $candidate = list<'red'|'blue'> */

    return $candidate;
}

/**
 * @psalm-pure
 *
 * @param array<string, mixed>|string $candidate
 * @return array<string, 'red'|'blue'>
 */
function allOneOfFiltersNonIterableNamedUnion(array|string $candidate): array
{
    $allowed = ['red', 'blue'];
    Assert::allOneOf(values: $allowed, value: $candidate);
    /** @psalm-check-type-exact $candidate = array<string, 'red'|'blue'> */

    return $candidate;
}

/**
 * @psalm-pure
 *
 * @param array<array-key, mixed>|null $candidate
 * @return array<array-key, 'red'|'blue'>
 */
function allOneOfFiltersNullNamedUnion(?array $candidate): array
{
    $allowed = ['red', 'blue'];
    Assert::allOneOf(values: $allowed, value: $candidate);
    /** @psalm-check-type-exact $candidate = array<array-key, 'red'|'blue'> */

    return $candidate;
}

/**
 * @psalm-pure
 *
 * @param Traversable<string, mixed> $candidate
 * @return iterable<string, 'red'|'blue'>
 */
function allOneOfNarrowsTraversableNamedCandidate(Traversable $candidate): iterable
{
    $allowed = ['red', 'blue'];
    Assert::allOneOf(values: $allowed, value: $candidate);

    return $candidate;
}

/**
 * @psalm-pure
 *
 * @param list<mixed> $values
 * @return list<'red'|'blue'>
 */
function allOneOfLiterals(array $values): array
{
    Assert::allOneOf($values, ['red', 'blue']);

    return $values;
}

/**
 * @psalm-pure
 *
 * @return 'red'|'blue'|null
 */
function nullOrOneOfLiterals(mixed $value): ?string
{
    Assert::nullOrOneOf($value, ['red', 'blue']);

    return $value;
}

/**
 * @psalm-pure
 *
 * @param array{first: mixed, second: mixed} $values
 * @return array{first: 'red'|'blue'|null, second: 'red'|'blue'|null}
 */
function allNullOrOneOfPreservesShape(array $values): array
{
    Assert::allNullOrOneOf($values, ['red', 'blue']);

    return $values;
}

/**
 * @psalm-pure
 *
 * @param list<mixed> $values
 * @return list<'red'|'blue'|null>
 */
function allNullOrInArrayAllowsNullEntries(array $values): array
{
    Assert::allNullOrInArray($values, ['red', 'blue']);

    return $values;
}

/**
 * @psalm-pure
 *
 * @param array{first: mixed, second?: mixed} $values
 * @return array{first: 'red'|'blue', second?: 'red'|'blue'}
 */
function allOneOfPreservesOptionalShape(array $values): array
{
    Assert::allOneOf($values, ['red', 'blue']);
    /** @psalm-check-type-exact $values = array{first: 'red'|'blue', second?: 'red'|'blue'} */

    return $values;
}

/**
 * @psalm-pure
 *
 * @return iterable<'red'|'blue'>
 */
function allOneOfMixedCollection(mixed $values): iterable
{
    Assert::allOneOf($values, ['red', 'blue']);

    return $values;
}
