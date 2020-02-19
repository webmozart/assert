<?php

namespace Webmozart\Assert\Tests\StaticAnalysis;

use Webmozart\Assert\Assert;

/**
 * @psalm-pure
 * @psalm-param non-empty-string $value
 *
 * @psalm-return non-empty-string
 */
function consume(string $value): string
{
    Assert::lengthBetween($value, 0, 2);

    return $value;
}