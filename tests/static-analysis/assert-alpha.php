<?php

namespace Webmozart\Assert\Tests\StaticAnalysis;

use Webmozart\Assert\Assert;

/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function alpha($value)
{
    Assert::alpha($value);

    return $value;
}

/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return mixed
 */
function nullOrAlpha($value)
{
    Assert::nullOrAlpha($value);

    return $value;
}

/**
 * @psalm-pure
 *
 * @param mixed $value
 */
function allAlpha($value): iterable
{
    Assert::allAlpha($value);

    return $value;
}
