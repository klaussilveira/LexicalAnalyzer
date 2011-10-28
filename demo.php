<?php

function __autoload($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once(__DIR__ . "/lib/$class.php");
}

$file = file_get_contents('sample.tex');

/**
 * We have a new instance of the LaTeX lexical analyzer, that will parse
 * the input string when we call the parse method, returning an array
 * of token objects
 */
$latex = new LexicalAnalyzer\Analyzers\LatexAnalyzer;
$tokens = $latex->parse($file);

foreach ($tokens as $token) {
    echo "{$token->type} at {$token->line}, {$token->column}:" . str_replace(PHP_EOL, '', $token->value) . PHP_EOL;
}
