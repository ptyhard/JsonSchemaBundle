<?php
$finder = PhpCsFixer\Finder::create();
$finder->in(__DIR__)
    ->exclude('vendor');

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
    ]);

return $config;
