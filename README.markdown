# LexicalAnalyzer
[![Build Status](https://secure.travis-ci.org/klaussilveira/LexicalAnalyzer.png)](http://travis-ci.org/klaussilveira/LexicalAnalyzer)

A simple library for lexical analysis written in PHP. Currently, LexicalAnalyzer only has a LaTeX extension, but it can be easily extended to support any other language. It works by receiveing either an input string or a resource and parsing it's contents into token objects, which then can be manipulated and used for many purposes. 

This library was built during the Linguágil 2011 event, in Salvador, along with Guto Maia. We had an insight while discussing Martin Fowler's book "Domain Specific Languages" and his approach to lexical analysis. This is a rough implementation, begging to be improved. It strongly relies on Guto Maia's "magical" regex.  

## Authors and contributors
* [Klaus Silveira](http://www.klaussilveira.com) (Creator, developer, support)
* [Guto Maia](http://www.guto.net) (Creator, developer, support)

## License
[New BSD license](http://www.opensource.org/licenses/bsd-license.php)

## Roadmap
* Support more languages
* Support more data handles

## Todo
* improve the current tests code coverage
* create a better documentation for implementing new languages
* error handling can be improved

## Using LexicalAnalyzer
Using the library is pretty simple. You must either read a string or open a resource, then create a new instance of the LexicalAnalyzer you want to use. In this case, let's use the LaTeX one. 

```php
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

```
