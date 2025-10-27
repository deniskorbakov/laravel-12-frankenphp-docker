<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\ClassMethod\InlineArrayReturnAssignRector;
use Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPromotedPropertyRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\Closure\ClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\StaticCall\MinutesToSecondsInCacheRector;
use RectorLaravel\Set\LaravelLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    // Paths to analyze
    $rectorConfig->paths([
                             __DIR__ . '/app',
                             __DIR__ . '/config',
                             __DIR__ . '/database',
                             __DIR__ . '/routes',
                             __DIR__ . '/tests',
                         ]);

    $rectorConfig->rules([
                             AddVoidReturnTypeWhereNoReturnRector::class,
                             DeclareStrictTypesRector::class,
                             ClosureReturnTypeRector::class,
                             ReturnTypeFromStrictTypedCallRector::class,
                             ReturnTypeFromStrictNewArrayRector::class,
                             ReturnTypeFromReturnDirectArrayRector::class,
                             TypedPropertyFromStrictConstructorRector::class,
                             CompleteDynamicPropertiesRector::class,
                             InlineArrayReturnAssignRector::class,
                             ExplicitBoolCompareRector::class,
                             SwitchNegatedTernaryRector::class,
                             NewlineBeforeNewAssignSetRector::class,
                             EncapsedStringsToSprintfRector::class,
                             PostIncDecToPreIncDecRector::class,
                             SymplifyQuoteEscapeRector::class,
                             RemoveUnusedPromotedPropertyRector::class,
                             RemoveUnusedPrivateMethodRector::class,
                             RemoveUnusedPrivatePropertyRector::class,
                             ClassPropertyAssignToConstructorPromotionRector::class,
                             ReadOnlyPropertyRector::class,
                             PrivatizeFinalClassMethodRector::class,
                             PrivatizeFinalClassPropertyRector::class,
                         ]);

    // Skip specific rules
    $rectorConfig->skip([
                            CompactToVariablesRector::class,
                            RemoveEmptyClassMethodRector::class,
                            RemoveNonExistingVarAnnotationRector::class,
                            MinutesToSecondsInCacheRector::class,
                            __DIR__ . '/app/Http/Controllers/Auth/AuthenticatedSessionController.php',
                        ]);

    // Enable caching for Rector
    $rectorConfig->cacheDirectory(__DIR__ . '/storage/rector');
    $rectorConfig->cacheClass(FileCacheStorage::class);

    // Apply sets for Laravel and general code quality
    $rectorConfig->sets([
                            LaravelLevelSetList::UP_TO_LARAVEL_110,
                            SetList::CODE_QUALITY,
                            SetList::TYPE_DECLARATION,
                            SetList::DEAD_CODE,
                            SetList::PRIVATIZATION,
                        ]);

    // Define PHP version for Rector
    $rectorConfig->phpVersion(PhpVersion::PHP_84);
};
