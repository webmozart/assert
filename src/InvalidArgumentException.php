<?php

/*
 * This file is part of the webmozart/assert package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\Assert;

class InvalidArgumentException extends \InvalidArgumentException
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $trace = $this->getTrace();

        $needFix = false;
        if (
            isset($trace[0]['class'], $trace[0]['function'], $trace[0]['file'], $trace[0]['line'])
            && $trace[0]['function'] === 'reportInvalidArgument'
            && $trace[0]['class'] === Assert::class
        ) {
            array_shift($trace);
            $needFix = true;
        }

        while (!isset($trace[0]['file'], $trace[0]['line'])) {
            array_shift($trace);
            $needFix = true;
        }

        if ($needFix) {
            try {
                $property = new \ReflectionProperty(\Exception::class, 'trace');
                $property->setAccessible(true);
                $property->setValue($this, $trace);
                $property->setAccessible(false);
            } catch (\Exception $ignored) {
            }

            if (isset($trace[0]['file'], $trace[0]['line'])) {
                $this->file = $trace[0]['file'];
                $this->line = $trace[0]['line'];
            }
        }
    }
}
