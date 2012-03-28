<?php

namespace LexicalAnalyzer\Handlers;

class StringHandle implements DataHandle
{
    private $data;
    
    function __construct($data)
    {
        $this->data = $data;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function hasMoreData()
    {
        return false;
    }

    public function isEndded()
    {
        return true;
    }
}
