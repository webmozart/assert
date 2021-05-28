<?php

namespace Webmozart\Assert\Tests\StaticAnalysis;

use Webmozart\Assert\Assert;

/**
 * @param mixed $p
 * @param mixed $q
 *
 * @return mixed
 */
function implies($p, $q)
{
    Assert::implies($p, $q);

    return $p;
}

/**
 * @param mixed $p
 * @param mixed $q
 *
 * @return mixed
 */
function nullOrImplies($p, $q)
{
    Assert::nullOrImplies($p, $q);

    return $p;
}

/**
 * @param mixed $p
 * @param mixed $q
 *
 * @return mixed
 */
function allImplies($p, $q)
{
    Assert::allImplies($p, $q);

    return $p;
}
