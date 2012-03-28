<?php

namespace LexicalAnalyzer\Analyzers;

abstract class Analyzer
{
    public $tokenTypes = array();
    
    public function parse($code)
    {
        if (is_string($code)){
            return $this->analyze(new \LexicalAnalyzer\Handlers\StringHandle($code));
        } elseif(is_resource($code)) {
            return $this->analyze(new \LexicalAnalyzer\Handlers\StreamHandle($code));
        }
    }
    
    public function analyze($handle)
    {
        $line = 1;
        $column = 1;
        $latex = $handle->getData();
        $tokens = array();

        while($handle->isEndded() || !empty($latex)) {
            if ($handle->hasMoreData()) {
                $latex .= $handle->getData();
            }
            
            $token = null;
            
            foreach ($this->tokenTypes as $tokenType => $property) {
                if (preg_match($property['regex'], $latex, $group)) {
                    $pointer = strlen($group[0]);
                    $latex = substr($latex, $pointer);
                    
                    $token = new \LexicalAnalyzer\Tokens\LatexToken;
                    $token->type = $tokenType;
                    $token->value = $group[0];
                    $token->line = $line;
                    $token->column = $column;
                    
                    if ($property['store']) {                
                        $tokens[] = $token;
                    }
                    
                    if (preg_match_all('/\n/', $group[0], $linefeeds)) {
                        $line += count($linefeeds[0]);
                        $column = 1;
                    }
                    
                    if (preg_match('/(.*\n)?([^\n]*)$/', $group[0], $columnfeeds)) {
                        $sizeof = count($columnfeeds) - 1;
                        $column += mb_strlen($columnfeeds[$sizeof], 'UTF-8');
                    }
                        
                    break;
                }
            }
            
            if ($token->type == 'T_EOF') {
                break;
            }
            
        }
        
        return $tokens;
    }
}
