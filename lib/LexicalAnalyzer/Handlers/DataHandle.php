<?php

namespace LexicalAnalyzer\Handlers;

interface DataHandle
{
    public function getData();
    public function hasMoreData();
    public function isEndded();
}
