<?php

declare(strict_types=1);

namespace Webmozart\Assert;

use Psalm\Internal\Analyzer\Statements\Expression\ExpressionIdentifier;
use Psalm\Plugin\EventHandler\AfterMethodCallAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterMethodCallAnalysisEvent;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\PluginRegistrationSocket;
use Psalm\Type;
use Psalm\Type\Atomic\TArray;
use Psalm\Type\Atomic\TIterable;
use Psalm\Type\Atomic\TKeyedArray;
use Psalm\Type\Atomic\TMixed;
use Psalm\Type\Atomic\TNonEmptyArray;
use Psalm\Type\Union;
use SimpleXMLElement;

final class PsalmPlugin implements PluginEntryPointInterface, AfterMethodCallAnalysisInterface
{
    public function __invoke(PluginRegistrationSocket $registration, ?SimpleXMLElement $config = null): void
    {
        $registration->registerHooksFromClass(self::class);
    }

    public static function afterMethodCallAnalysis(AfterMethodCallAnalysisEvent $event): void
    {
        [$class, $method] = explode('::', $event->getAppearingMethodId());
        if ($class !== Assert::class) {
            return;
        }
        if (!isset(HasAssert::HAS_ASSERT[$method])) {
            return;
        }

        $args = $event->getExpr()->getArgs();
        $isMembership = \in_array(\strtolower($method), ['oneof', 'inarray', 'nulloroneof', 'nullorinarray', 'alloneof', 'allinarray', 'allnulloroneof', 'allnullorinarray'], true);
        $firstArg = $isMembership
            ? self::getArgument($args, 'value', 0)
            : ($args[0] ?? null);
        if ($firstArg === null) {
            return;
        }

        $varId = ExpressionIdentifier::getExtendedVarId(
            $firstArg->value,
            $event->getContext()->self,
            $event->getStatementsSource()
        );

        if ($varId === null || !isset($event->getContext()->vars_in_scope[$varId])) {
            return;
        }

        $candidateType = $event->getContext()->vars_in_scope[$varId];

        if ($isMembership) {
            $valuesArg = self::getArgument($args, 'values', 1);
            if ($valuesArg === null) {
                return;
            }

            $valuesType = $event->getStatementsSource()->getNodeTypeProvider()->getType($valuesArg->value);
            if ($valuesType === null || !$valuesType->hasArray()) {
                return;
            }

            $allowedType = match (true) {
                $valuesType->getArray() instanceof TKeyedArray => $valuesType->getArray()->getGenericValueType(),
                $valuesType->getArray() instanceof TArray => $valuesType->getArray()->type_params[1],
                default => null,
            };
            if ($allowedType === null) {
                return;
            }

            if (\str_starts_with(\strtolower($method), 'nullor') || \str_starts_with(\strtolower($method), 'allnullor')) {
                $allowedType = Type::combineUnionTypes($allowedType, Type::getNull(), $event->getCodebase());
            }

            $isAll = \str_starts_with(\strtolower($method), 'all');
            $candidateType = $isAll
                ? self::narrowIterable($candidateType, $allowedType, $event)
                : self::intersect($candidateType, $allowedType, $event);

            $event->getContext()->vars_in_scope[$varId] = $candidateType;
            $event->setReturnTypeCandidate($candidateType);

            return;
        }

        $event->setReturnTypeCandidate($candidateType);
    }

    /**
     * @param list<\PhpParser\Node\Arg> $args
     */
    private static function getArgument(array $args, string $name, int $position): ?\PhpParser\Node\Arg
    {
        foreach ($args as $arg) {
            if (!$arg->unpack && $arg->name?->name === $name) {
                return $arg;
            }
        }

        $arg = $args[$position] ?? null;

        return $arg !== null && $arg->name === null && !$arg->unpack ? $arg : null;
    }

    private static function intersect(Union $type, Union $allowedType, AfterMethodCallAnalysisEvent $event): Union
    {
        return Type::intersectUnionTypes($type, $allowedType, $event->getCodebase(), false, false) ?? Type::getNever();
    }

    private static function narrowIterable(Union $type, Union $allowedType, AfterMethodCallAnalysisEvent $event): Union
    {
        $narrowed = [];

        foreach ($type->getAtomicTypes() as $atomicType) {
            if ($atomicType instanceof TKeyedArray) {
                $properties = $atomicType->properties;
                foreach ($atomicType->properties as $key => $propertyType) {
                    $properties[$key] = self::intersect($propertyType, $allowedType, $event)
                        ->setPossiblyUndefined($propertyType->possibly_undefined, $propertyType->possibly_undefined_from_try);
                }
                $fallbackParams = $atomicType->fallback_params;
                if ($fallbackParams !== null) {
                    $fallbackParams[1] = self::intersect($fallbackParams[1], $allowedType, $event);
                }
                $narrowed[] = new TKeyedArray(
                    $properties,
                    $atomicType->class_strings,
                    $fallbackParams,
                    $atomicType->is_list,
                    $atomicType->from_docblock,
                );
            } elseif ($atomicType instanceof TNonEmptyArray) {
                $narrowed[] = new TNonEmptyArray(
                    [
                        $atomicType->type_params[0],
                        self::intersect($atomicType->type_params[1], $allowedType, $event),
                    ],
                    $atomicType->count,
                    $atomicType->min_count,
                    $atomicType->value,
                    $atomicType->from_docblock,
                );
            } elseif ($atomicType instanceof TArray) {
                $narrowed[] = new TArray(
                    [
                        $atomicType->type_params[0],
                        self::intersect($atomicType->type_params[1], $allowedType, $event),
                    ],
                    $atomicType->from_docblock,
                );
            } elseif ($atomicType instanceof TIterable) {
                $narrowed[] = new TIterable([
                    $atomicType->type_params[0],
                    self::intersect($atomicType->type_params[1], $allowedType, $event),
                ], $atomicType->extra_types);
            } elseif ($atomicType instanceof TMixed) {
                $narrowed[] = new TIterable([Type::getMixed(), $allowedType]);
            } elseif ($atomicType->isIterable($event->getCodebase())) {
                $iterableType = $atomicType->getIterable($event->getCodebase());
                $narrowed[] = new TIterable([
                    $iterableType->type_params[0],
                    self::intersect($iterableType->type_params[1], $allowedType, $event),
                ], [$atomicType]);
            } else {
                continue;
            }
        }

        return $narrowed === [] ? Type::getNever() : new Union($narrowed);
    }
}
