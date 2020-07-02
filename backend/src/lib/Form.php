<?php

namespace skoolBiep;

class Form
{
    static function createForm($response, $twig, $fields, $theme)
    {
        $template = $theme . '.html.twig';
        $t = $twig->render($response, $template, ['data' => $fields]);
        return $t;
    }
}
