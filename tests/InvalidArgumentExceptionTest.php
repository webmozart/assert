<?php

declare(strict_types=1);

namespace Webmozart\Assert\Tests;

use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class InvalidArgumentExceptionTest extends TestCase
{
    public function testAssertFileLine()
    {
        try {
            $line = __LINE__;
            Assert::notNull(null);
            $this->fail('Assertion not triggered');
        } catch (\Exception $e) {
            $this->assertEquals($line + 1, $e->getLine());
            $this->assertEquals(__FILE__, $e->getFile());
        }
    }

    public function testAssertStackTrace()
    {
        try {
            $line = __LINE__;
            Assert::notNull(null);
            $this->fail('Assertion not triggered');
        } catch (\Exception $e) {
            $this->assertStringStartsWith(
                sprintf(
                    '#0 %s(%d): Webmozart\Assert\Assert::notNull',
                    __FILE__,
                    $line + 1
                ),
                $e->getTraceAsString()
            );
        }
    }

    public function testAssertTraceArray()
    {
        try {
            $line = __LINE__;
            Assert::notNull(null);
            $this->fail('Assertion not triggered');
        } catch (\Exception $e) {
            $trace = $e->getTrace();

            $this->assertIsArray($trace);
            $this->assertArrayHasKey(0, $trace);
            $this->assertEquals(__FILE__, $trace[0]['file']);
            $this->assertEquals($line + 1, $trace[0]['line']);
        }
    }

    public function testThrowException()
    {
        try {
            throw new InvalidArgumentException();
        } catch (\Exception $e) {
            $trace = $e->getTrace();
            $this->assertEquals(__CLASS__, $trace[0]['class']);
        }
    }

    public function testCallUserFunction()
    {
        try {
            $line = __LINE__;
            call_user_func_array(array(Assert::class, 'notNull'), array(null));
            $this->fail('Assertion not triggered');
        } catch (\Exception $e) {
            $trace = $e->getTrace();

            $this->assertIsArray($trace);
            $this->assertArrayHasKey(0, $trace);
            $this->assertEquals(__FILE__, $trace[0]['file']);
            $this->assertEquals($line + 1, $trace[0]['line']);
        }
    }
}
