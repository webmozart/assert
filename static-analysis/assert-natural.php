<?php

namespace Webmozart\Assert\StaticAnalysis\AssertString;

use Webmozart\Assert\Assert;

/** @param mixed $value */
function consume($value) : int
{
    Assert::natural($value);

    return $value;
}
