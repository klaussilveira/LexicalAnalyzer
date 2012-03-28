<?php

namespace LexicalAnalyzer\Tokens;

abstract class Token
{
    public $type;
    public $value;
    public $line;
    public $column;
}
