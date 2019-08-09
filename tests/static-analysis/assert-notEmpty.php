<?php

namespace Webmozart\Assert\Tests\StaticAnalysis;

use Webmozart\Assert\Assert;

function consume(?object $value): object
{
    Assert::notEmpty($value);

    return $value;
}
