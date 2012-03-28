<?php

namespace LexicalAnalyzer\Handlers;

class StreamHandle implements DataHandle
{
    private $data;
    private $status = true;
    
    function __construct($data)
    {
        $this->data = $data;
    }
    
    public function getData()
    {
        $data = fgets($this->data, 8192);
        
        $this->status = ($data !== false);
        return $data;
    }
    
    public function hasMoreData()
    {
        return true;
    }
    
    public function isEndded()
    {
        return $this->status;
    }
}
