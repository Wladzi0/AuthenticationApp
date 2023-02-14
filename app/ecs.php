<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocLineSpanFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypehintFixer;
use PhpCsFixerCustomFixers\Fixer\NoImportFromGlobalNamespaceFixer;
use PhpCsFixerCustomFixers\Fixer\NoSuperfluousConcatenationFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessStrlenFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocNoIncorrectVarAnnotationFixer;
use PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        '.gitlab-ci/tools/src',
        '.gitlab-ci/tools/tests',
        'public/index.php',
        'ecs.php',
        'bin/console',
    ]);

    $services = $containerConfigurator->services();
    // run and fix, one by one
    $containerConfigurator->sets([
        SetList::ARRAY,
        SetList::DOCBLOCK,
        SetList::PSR_12,
        SetList::DOCTRINE_ANNOTATIONS,
        SetList::COMMON,
        SetList::CLEAN_CODE,
        SetList::SYMPLIFY,
        SetList::CONTROL_STRUCTURES,
        SetList::SPACES,
    ]);

    $services->set(ModernizeTypesCastingFixer::class);
    $services->set(ClassAttributesSeparationFixer::class)
        ->call('configure', [[
            'elements' => [
                'property' => 'one',
                'method' => 'one',
            ],
        ]]);
    $services->set(FopenFlagsFixer::class);
    $services->set(MethodArgumentSpaceFixer::class)
        ->call('configure', [[
            'on_multiline' => 'ensure_fully_multiline',
        ]]);
    $services->set(NativeFunctionInvocationFixer::class)
        ->call('configure', [[
            'include' => [NativeFunctionInvocationFixer::SET_COMPILER_OPTIMIZED],
            'scope' => 'namespaced',
            'strict' => false,
        ]]);
    $services->set(NativeConstantInvocationFixer::class);
    $services->set(NullableTypeDeclarationForDefaultNullValueFixer::class);
    $services->set(VoidReturnFixer::class);
    $services->set(ConcatSpaceFixer::class)
        ->call('configure', [[
            'spacing' => 'one',
        ]]);
    $services->set(OperatorLinebreakFixer::class);
    $services->set(GeneralPhpdocAnnotationRemoveFixer::class)
        ->call('configure', [[
            'annotations' => ['copyright', 'category'],
        ]]);
    $services->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call('configure', [[
            'allow_unused_params' => true,
        ]]);
    $services->set(PhpdocLineSpanFixer::class);
    $services->set(PhpdocOrderFixer::class);
    $services->set(PhpUnitConstructFixer::class);
    $services->set(PhpUnitDedicateAssertFixer::class)
        ->call('configure', [[
            'target' => 'newest',
        ]]);
    $services->set(PhpUnitDedicateAssertInternalTypeFixer::class);
    $services->set(PhpUnitMockFixer::class);
    $services->set(PhpUnitMockShortWillReturnFixer::class);
    $services->set(PhpUnitTestCaseStaticMethodCallsFixer::class);
    $services->set(NoUselessReturnFixer::class);
    $services->set(DeclareStrictTypesFixer::class);
    $services->set(BlankLineBeforeStatementFixer::class);
    $services->set(CompactNullableTypehintFixer::class);
    $services->set(NoImportFromGlobalNamespaceFixer::class);
    $services->set(NoUselessStrlenFixer::class);
    $services->set(SingleSpaceAfterStatementFixer::class);
    $services->set(PhpdocNoIncorrectVarAnnotationFixer::class);
    $services->set(NoSuperfluousConcatenationFixer::class);
    $services->set(LineLengthFixer::class);

    $containerConfigurator->skip([
        YodaStyleFixer::class,
        PhpUnitTestClassRequiresCoversFixer::class,
        MethodChainingNewlineFixer::class,
        MultilineWhitespaceBeforeSemicolonsFixer::class,
        PhpdocTypesOrderFixer::class,
        PhpdocToCommentFixer::class,
        GeneralPhpdocAnnotationRemoveFixer::class => [__DIR__ . '/tests/'],
    ]);
};
