<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src',__DIR__ . '/tests']);

$config = (new PhpCsFixer\Config())
    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers());;

return $config->setRules([
    '@PSR12' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => true,
    'no_unused_imports' => true,
    'yoda_style' => false,
    'php_unit_method_casing' => ['case' => 'snake_case'],
    PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer::name() => true
])->setFinder($finder);
