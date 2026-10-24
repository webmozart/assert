<?php

declare(strict_types=1);

namespace Webmozart\Assert\Bin;

use ArrayAccess;
use Countable;
use ReflectionClass;
use ReflectionException;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionType;
use ReflectionUnionType;
use RuntimeException;
use Throwable;
use Webmozart\Assert\Assert;

final class MixinGenerator
{
    private const MEMBERSHIP_ASSERTIONS = [
        'oneof', 'inarray', 'nulloroneof', 'nullorinarray',
        'alloneof', 'allinarray', 'allnulloroneof', 'allnullorinarray',
    ];

    /**
     * @psalm-var list<string>
     *
     * @var string[]
     */
    private array $unsupportedMethods = [
        'nullOrNotInstanceOf',  // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'allNotInstanceOf',     // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'nullOrNotEmpty',       // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'allNotEmpty',          // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'allNotNull',           // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'nullOrIsNotA',         // not supported by psalm (https://github.com/vimeo/psalm/issues/3444)
        'allIsNotA',            // not supported by psalm (https://github.com/vimeo/psalm/issues/3444)
        'nullOrNotFalse',       // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'allNotFalse',          // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'nullOrUpper',          // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'allUpper',             // not supported by psalm (https://github.com/vimeo/psalm/issues/3443)
        'nullOrIsNonEmptyMap',  // not supported by psalm (https://github.com/vimeo/psalm/issues/3444)
        'allIsNonEmptyMap',     // not supported by psalm (https://github.com/vimeo/psalm/issues/3444)
    ];

    private array $skipGenerateForMethods = [
        'isInitialized',
    ];

    /**
     * @psalm-var list<string>
     *
     * @var string[]
     */
    private array $skipMethods = [
        'nullOrNull',           // meaningless
        'nullOrNotNull',        // meaningless
        'allNullOrNull',        // meaningless
        'allNullOrNotNull',     // meaningless
    ];

    /**
     * @var array<string, bool>
     */
    private array $haveAssert = [];

    public function generateHasAssert(): string {
        $res = <<<'PHP'
<?php

declare(strict_types=1);

namespace Webmozart\Assert;

/** @internal Used by the Psalm plugin */
final class HasAssert
{
    public const HAS_ASSERT = [

PHP;
        foreach ($this->haveAssert as $name => $has) {
            if ($has) {
                $name = strtolower($name);
                $res .= "        '$name' => true,\n";
            }
        }
        $res .= "    ];\n}\n";
        return $res;
    }

    public function generate(): string
    {
        return \sprintf(
            <<<'PHP'
<?php

declare(strict_types=1);

%s
PHP
            ,
            $this->namespace()
        );
    }

    private function namespace(): string
    {
        $assert = new ReflectionClass(Assert::class);

        $namespace = sprintf("namespace %s;\n\n", $assert->getNamespaceName());
        $namespace .= sprintf("use %s;\n", ArrayAccess::class);
        $namespace .= sprintf("use %s;\n", \Closure::class);
        $namespace .= sprintf("use %s;\n", Countable::class);
        $namespace .= sprintf("use %s;\n", Throwable::class);
        $namespace .= "\n";

        $namespace .= $this->trait($assert);

        return $namespace;
    }

    private function trait(ReflectionClass $assert): string
    {
        $staticMethods = $this->getMethods($assert);

        $declaredMethods = [];

        foreach ($staticMethods as $method) {
            $this->haveAssert[$method->getName()] = $this->hasAssertion($method->getName(), $method->getDocComment());

            $nullOr = $this->nullOr($method, 4);
            if (null !== $nullOr) {
                $this->haveAssert["nullOr".$method->getName()] = $this->hasAssertion("nullOr".$method->getName(), $nullOr);
                $declaredMethods[] = $nullOr;
            }

            $all = $this->all($method, 4);
            if (null !== $all) {
                $this->haveAssert["all".$method->getName()] = $this->hasAssertion("all".$method->getName(), $all);
                $declaredMethods[] = $all;
            }

            $allNullOr = $this->allNullOr($method, 4);
            if (null !== $allNullOr) {
                $this->haveAssert["allNullOr".$method->getName()] = $this->hasAssertion("allNullOr".$method->getName(), $allNullOr);
                $declaredMethods[] = $allNullOr;
            }
        }

        return \sprintf(
            <<<'PHP'
/**
 * This trait provides nullOr*, all* and allNullOr* variants of assertion base methods.
 * Do not use this trait directly: it will change, and is not designed for reuse.
 */
trait Mixin
{
%s
}

PHP
            ,
            \implode("\n\n", $declaredMethods)
        );
    }

    private function hasAssertion(string $methodName, string $docComment): bool
    {
        return str_contains($docComment, '@psalm-assert')
            || in_array(strtolower($methodName), self::MEMBERSHIP_ASSERTIONS, true);
    }

    /**
     * @param ReflectionMethod $method
     * @param int              $indent
     *
     * @return string|null
     *
     * @throws ReflectionException
     */
    private function nullOr(ReflectionMethod $method, int $indent): ?string
    {
        return $this->assertion($method, 'nullOr%s', '%s|null', $indent, function (string $firstParameter, string $parameters) use ($method) {
            return <<<BODY
null === {$firstParameter} || static::{$method->name}({$firstParameter}, {$parameters});

return {$firstParameter};
BODY;
        });
    }

    /**
     * @param ReflectionMethod $method
     * @param int              $indent
     *
     * @return string|null
     *
     * @throws ReflectionException
     */
    private function all(ReflectionMethod $method, int $indent): ?string
    {
        return $this->assertion($method, 'all%s', 'iterable<%s>', $indent, function (string $firstParameter, string $parameters) use ($method) {
            return <<<BODY
static::isIterable({$firstParameter});

foreach ({$firstParameter} as \$entry) {
    static::{$method->name}(\$entry, {$parameters});
}

return {$firstParameter};
BODY;
        });
    }

    /**
     * @param ReflectionMethod $method
     * @param int              $indent
     *
     * @return string|null
     *
     * @throws ReflectionException
     */
    private function allNullOr(ReflectionMethod $method, int $indent): ?string
    {
        return $this->assertion($method, 'allNullOr%s', 'iterable<%s|null>', $indent, function (string $firstParameter, string $parameters) use ($method) {
            return <<<BODY
static::isIterable({$firstParameter});

foreach ({$firstParameter} as \$entry) {
    null === \$entry || static::{$method->name}(\$entry, {$parameters});
}

return {$firstParameter};
BODY;
        });
    }

    /**
     * @psalm-param callable(string,string):string $body
     *
     * @param ReflectionMethod $method
     * @param string           $methodNameTemplate
     * @param string           $typeTemplate
     * @param int              $indent
     * @param callable         $body
     *
     * @return string|null
     *
     * @throws ReflectionException
     */
    private function assertion(ReflectionMethod $method, string $methodNameTemplate, string $typeTemplate, int $indent, callable $body): ?string
    {
        $newMethodName = sprintf($methodNameTemplate, ucfirst($method->name));

        $comment = $method->getDocComment();

        $parsedComment = $this->parseDocComment($comment);

        $parameters = [];
        /** @psalm-var array<string, scalar|null> $parametersDefaults */
        $parametersDefaults = [];
        /** @var array<string, string> $parameterTypes */
        $parameterTypes = [];
        $parametersReflection = $method->getParameters();
        $nativeReturnType = 'mixed';

        foreach ($parametersReflection as $parameterReflection) {
            $parameters[] = $parameterReflection->name;

            if ($parameterReflection->isDefaultValueAvailable()) {
                $defaultValue = $parameterReflection->getDefaultValue();
                $defaultValue = Assert::nullOrScalar($defaultValue);

                $parametersDefaults[$parameterReflection->name] = $defaultValue;
            }

            if ($parameterReflection->hasType()) {
                if (count($parameters) === 1) {
                    $parameterTypes[$parameterReflection->name] = 'mixed';

                    $nativeReturnType = match ($typeTemplate) {
                        '%s|null' => $this->nullableReturnType($method->getReturnType()),
                        'iterable<%s>' => 'iterable',
                        'iterable<%s|null>' => 'iterable',
                    };
                } else {
                    $parameterTypes[$parameterReflection->name] = $this->reduceParameterType($parameterReflection->getType());
                }
            }
        }

        // Ensure @template comes before @param, and @param values match function signature order
        $parsedComment = $this->reorderAnnotations($parsedComment);
        if (isset($parsedComment['param'])) {
            $parsedComment['param'] = $this->reorderParamsBySignature($parsedComment['param'], $parameters);
        }

        if (in_array($newMethodName, $this->skipMethods, true)) {
            return null;
        }

        $paramsAdded = false;

        $phpdocReturnType = 'mixed';

        $templateTypeNames = [];
        if (isset($parsedComment['template'])) {
            foreach ($parsedComment['template'] as $template) {
                $templateTypeNames[] = explode(' ', $template)[0];
            }
        }

        $phpdocLines = [];
        foreach ($parsedComment as $key => $values) {
            if ($this->shouldSkipAnnotation($newMethodName, $key)) {
                continue;
            }

            if ($paramsAdded || 'param' === $key) {
                $paramsAdded = true;
                if (count($phpdocLines) > 0) {
                    $phpdocLines[] = '';
                }
            }

            if ('deprecated' === $key) {
                $phpdocLines[] = '';
            }

            $longestType = 0;
            $longestName = 0;

            foreach ($values as $i => $value) {
                $parts = $this->splitDocLine($value);
                if ('param' === $key && isset($parts[1]) && isset($parameters[0]) && $parts[1] === '$'.$parameters[0] && 'mixed' !== $parts[0]) {
                    $parts[0] = $this->applyTypeTemplate($parts[0], $typeTemplate, $templateTypeNames);

                    $values[$i] = \implode(' ', $parts);

                    if ('mixed' === $phpdocReturnType) {
                        $phpdocReturnType = $parts[0];
                    }
                }
            }

            if ('return' === $key) {
                foreach ($values as $value) {
                    $parts = $this->splitDocLine($value);
                    if ('mixed' !== $parts[0]) {
                        $phpdocReturnType = $this->applyTypeTemplate($parts[0], $typeTemplate, $templateTypeNames, $this->preservesNullEntries($newMethodName));
                    }
                }
                continue;
            }

            if ('param' === $key) {
                [$longestType, $longestName] = $this->findLongestTypeAndName($values);
            }

            foreach ($values as $value) {
                $parts = $this->splitDocLine($value);
                $type = $parts[0];

                if ('template' === $key && 'iterable<%s|null>' === $typeTemplate) {
                    $type = preg_replace('/^(\S+\s+(?:of|as)\s+)(.+)$/', '$1$2|null', $type) ?? $type;
                }

                if ('psalm-assert' === $key) {
                    $type = $this->applyTypeTemplate($type, $typeTemplate, $templateTypeNames, $this->preservesNullEntries($newMethodName));

                    $phpdocReturnType = $type;
                }

                if ('param' === $key) {
                    if (!isset($parts[1])) {
                        throw new RuntimeException(sprintf('param key must come with type and variable name in method: %s', $method->name));
                    }

                    $type = str_pad($type, $longestType, ' ');
                    $parts[1] = str_pad($parts[1], $longestName, ' ');
                }

                $comment = sprintf('@%s %s', $key, $type);
                if (count($parts) >= 2) {
                    $comment .= sprintf(' %s', \implode(' ', array_slice($parts, 1)));
                }

                $phpdocLines[] = trim($comment);
            }

            if ('deprecated' === $key || 'psalm-pure' === $key || 'psalm-assert' === $key || 'see' === $key) {
                $phpdocLines[] = '';
            }
        }

        if ('mixed' === $phpdocReturnType) {
            $returnType = $method->getReturnType();
            if ($returnType !== null) {
                $returnTypeStr = $this->reduceParameterType($returnType);
                if ('mixed' !== $returnTypeStr) {
                    $phpdocReturnType = $this->applyTypeTemplate($returnTypeStr, $typeTemplate, $templateTypeNames);
                }
            }
        }

        if ('mixed' === $phpdocReturnType && 'mixed' !== $nativeReturnType) {
            $phpdocReturnType = $nativeReturnType;
        }

        $phpdocLines[] = '@return '.$phpdocReturnType;
        $phpdocLines[] = '';

        $phpdocLinesDeduplicatedEmptyLines = [];
        foreach ($phpdocLines as $line) {
            $currentLine = trim($line);
            if ('' === $currentLine && count($phpdocLinesDeduplicatedEmptyLines) > 0) {
                $previousLine = trim($phpdocLinesDeduplicatedEmptyLines[count($phpdocLinesDeduplicatedEmptyLines) - 1]);
                if ('' === $previousLine) {
                    continue;
                }
            }

            $phpdocLinesDeduplicatedEmptyLines[] = $line;
        }

        return $this->staticMethod($newMethodName, $parameters, $parameterTypes, $parametersDefaults, $phpdocLinesDeduplicatedEmptyLines, $indent, $body, $nativeReturnType);
    }

    private function reduceParameterType(ReflectionType $type): string
    {
        if ($type instanceof ReflectionIntersectionType) {
            return \implode('&', \array_map([$this, 'reduceParameterType'], $type->getTypes()));
        }

        if ($type instanceof ReflectionUnionType) {
            return \implode('|', \array_map([$this, 'reduceParameterType'], $type->getTypes()));
        }

        $type = Assert::isInstanceOf($type, ReflectionNamedType::class);

        if ($type->getName() === 'mixed') {
            return $type->getName();
        }

        return ($type->allowsNull() ? '?' : '') . $type->getName();
    }

    private function nullableReturnType(?ReflectionType $type): string
    {
        if ($type === null) {
            return 'mixed';
        }
        $typeStr = $this->reduceParameterType($type);
        if ($typeStr === 'mixed') {
            return 'mixed';
        }
        if ($type instanceof ReflectionUnionType || $type instanceof ReflectionIntersectionType) {
            return $typeStr.'|null';
        }

        return '?'.$typeStr;
    }

    private function applyTypeTemplate(string $type, string $typeTemplate, array $templateTypeNames = [], bool $preserveNullEntries = false): string
    {
        if (!$preserveNullEntries && in_array($type, $templateTypeNames, true) && str_contains($typeTemplate, 'iterable') && str_contains($typeTemplate, '|null')) {
            $typeTemplate = str_replace('|null', '', $typeTemplate);
        }

        $combinedType = sprintf($typeTemplate, $type);

        if ('empty|null' === $combinedType) {
            $combinedType = 'empty'; // @see https://github.com/vimeo/psalm/issues/3492
        }

        return $combinedType;
    }

    private function preservesNullEntries(string $methodName): bool
    {
        return in_array(strtolower($methodName), ['allnulloroneof', 'allnullorinarray'], true);
    }

    private function shouldSkipAnnotation(string $newMethodName, string $key): bool
    {
        if (!in_array($newMethodName, $this->unsupportedMethods, true)) {
            return false;
        }

        return 'psalm-assert' === $key;
    }

    /**
     * @psalm-param array<int, string> $values
     * @psalm-return array{int, int}
     *
     * @param string[] $values
     *
     * @return int[]
     */
    private function findLongestTypeAndName(array $values): array
    {
        $longestType = 0;
        $longestName = 0;

        foreach ($values as $value) {
            $parts = $this->splitDocLine($value);
            $type = $parts[0];
            if (strlen($type) > $longestType) {
                $longestType = strlen($type);
            }

            if (!isset($parts[1])) {
                continue;
            }

            $name = $parts[1];
            if (strlen($name) > $longestName) {
                $longestName = strlen($name);
            }
        }

        return [$longestType, $longestName];
    }

    /**
     * @psalm-param list<string>                   $parameters
     * @psalm-param array<string, scalar|null>     $defaults
     * @psalm-param list<string>                   $phpdocLines
     *
     * @param string                               $name
     * @param string[]                             $parameters
     * @param array<string, string>                $types
     * @param string[]                             $defaults
     * @param array                                $phpdocLines
     * @param int                                  $indent
     * @param callable(string,string): string      $body
     * @param string                               $returnType
     *
     * @return string
     */
    private function staticMethod(string $name, array $parameters, array $types, array $defaults, array $phpdocLines, int $indent, callable $body, string $returnType): string
    {
        Assert::notEmpty($parameters);

        $indentation = str_repeat(' ', $indent);

        $parameterList = \array_map(static fn (string $parameter): string => '$'.$parameter, $parameters);
        $firstParameter = \array_shift($parameterList);
        $parameterList = \implode(', ', $parameterList);

        $methodBody = \preg_replace('/(?<=^|\n)(?!\n)/', $indentation.$indentation, $body($firstParameter, $parameterList));

        Assert::stringNotEmpty($methodBody);

        $staticFunction = $this->phpdoc($phpdocLines, $indent)."\n";
        $staticFunction .= $indentation.'public static function '.$name.$this->functionParameters($parameters, $types, $defaults).": {$returnType}\n"
            .$indentation."{\n";
        $staticFunction .= $methodBody."\n".$indentation."}";

        return $staticFunction;
    }

    /**
     * @psalm-param list<string>               $parameters
     * @psalm-param array<string, scalar|null> $defaults
     *
     * @param string[]                         $parameters
     * @param array<string, string>            $types
     * @param string[]                         $defaults
     *
     * @return string
     */
    private function functionParameters(array $parameters, array $types, array $defaults): string
    {
        $result = '';

        foreach ($parameters as $i => $parameter) {
            if ($i > 0) {
                $result .= ', ';
            }

            Assert::keyExists($types, $parameter);

            $result .= $types[$parameter].' $'.$parameter;

            if (array_key_exists($parameter, $defaults)) {
                $defaultValue = null === $defaults[$parameter] ? 'null' : var_export($defaults[$parameter], true);

                $result .= ' = '.$defaultValue;
            }
        }

        return '('.$result.')';
    }

    /**
     * @psalm-param list<string> $lines
     *
     * @param string[] $lines
     * @param int      $indent
     *
     * @return string
     */
    private function phpdoc(array $lines, int $indent): string
    {
        $indentation = str_repeat(' ', $indent);

        $phpdoc = $indentation.'/**';
        $throws = '';

        foreach ($lines as $line) {
            if (\str_starts_with($line, '@throws')) {
                $throws .= "\n".$indentation.\rtrim(' * '.$line);
            } else {
                $phpdoc .= "\n".$indentation.\rtrim(' * '.$line);
            }
        }

        if (strlen($throws) > 0) {
            $phpdoc .= $throws;
        }

        $phpdoc .= "\n".$indentation.' */';

        return $phpdoc;
    }

    /**
     * @psalm-return array<string, list<string>>
     *
     * @param string $comment
     *
     * @return string[][]
     */
    private function parseDocComment(string $comment): array
    {
        $lines = explode("\n", $comment);

        $result = [];

        foreach ($lines as $line) {
            if (preg_match('~^\*\s+@(\S+)(\s+.*)?$~', trim($line), $matches)) {
                if (2 === count($matches)) {
                    $matches[2] = '';
                }
                $result[$matches[1]][] = trim($matches[2]);
            }
        }

        return $result;
    }

    /**
     * @psalm-return list{string, string|null, string|null}
     *
     * @param string $line
     *
     * @return string[]
     */
    private function splitDocLine(string $line): array
    {
        if (!preg_match('~^(.*)\s+(\$\S+)(?:\s+(.*))?$~', $line, $matches)) {
            return [$line, null, null];
        }

        return [trim($matches[1]), $matches[2], $matches[3] ?? null];
    }

    /**
     * Ensures @template annotations appear before @param annotations.
     *
     * @param array<string, list<string>> $annotations
     *
     * @return array<string, list<string>>
     */
    private function reorderAnnotations(array $annotations): array
    {
        $keys = array_keys($annotations);
        $templatePos = array_search('template', $keys, true);
        $paramPos = array_search('param', $keys, true);

        if ($templatePos === false || $paramPos === false || $templatePos < $paramPos) {
            return $annotations;
        }

        $result = [];
        foreach ($annotations as $key => $values) {
            if ($key === 'param') {
                $result['template'] = $annotations['template'];
            }
            if ($key !== 'template') {
                $result[$key] = $values;
            }
        }

        return $result;
    }

    /**
     * Reorders @param doc entries to match the function signature parameter order.
     *
     * @param list<string> $paramDocs
     * @param list<string> $parameterNames
     *
     * @return list<string>
     */
    private function reorderParamsBySignature(array $paramDocs, array $parameterNames): array
    {
        $byVarName = [];
        $withoutVarName = [];

        foreach ($paramDocs as $doc) {
            $parts = $this->splitDocLine($doc);
            if (isset($parts[1])) {
                $byVarName[$parts[1]] = $doc;
            } else {
                $withoutVarName[] = $doc;
            }
        }

        $ordered = [];
        foreach ($parameterNames as $name) {
            $key = '$'.$name;
            if (isset($byVarName[$key])) {
                $ordered[] = $byVarName[$key];
                unset($byVarName[$key]);
            }
        }

        return array_merge($ordered, array_values($byVarName), $withoutVarName);
    }

    /**
     * @psalm-return list<ReflectionMethod>
     *
     * @param ReflectionClass $assert
     *
     * @return ReflectionMethod[]
     */
    private function getMethods(ReflectionClass $assert): array
    {
        $methods = [];

        $staticMethods = $assert->getMethods(ReflectionMethod::IS_STATIC);

        foreach ($staticMethods as $staticMethod) {
            if (in_array($staticMethod->name, $this->skipGenerateForMethods)) {
                continue;
            }

            $modifiers = $staticMethod->getModifiers();
            if (0 === ($modifiers & ReflectionMethod::IS_PUBLIC)) {
                continue;
            }

            if ($staticMethod->getFileName() !== $assert->getFileName()) {
                // Skip this method - was imported by generated mixin
                continue;
            }

            if ('__callStatic' === $staticMethod->name) {
                continue;
            }

            $methods[] = $staticMethod;
        }

        return $methods;
    }
}
