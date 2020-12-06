<?php

namespace skoolBiep\Util;

class TranslateReadingLevel
{
    private $arr = array(
        "NOT_MATURE" => "Everybody",
        "MATURE" => "Adult",
    );

    public function __invoke($key)
    {
        return $this->arr[$key]        ;
    }
}
