<?php

namespace Webmozart\Assert\StaticAnalysis\AssertString;

use Webmozart\Assert\Assert;

/**
 * @psalm-param mixed $value
 */
function consume($value): callable
{
    Assert::isCallable($value);

    return $value;
}
