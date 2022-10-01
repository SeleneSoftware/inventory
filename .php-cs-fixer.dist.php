<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('var')
    ->exclude('public')
    ->exclude('vendor')
    ->exclude('node_modules')
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'align_multiline_comment' => true,
    '@DoctrineAnnotation' => true,
    'class_attributes_separation' => true,
    'no_extra_blank_lines' => true,
    'ordered_imports' => true,
    // 'no_multiple_statements_per_line' => true,
    '@PHP81Migration' => true,
    '@PhpCsFixer' => true,
    'class_attributes_separation' => ['elements' => ['property' => 'one']],
])
    ->setFinder($finder)
;
