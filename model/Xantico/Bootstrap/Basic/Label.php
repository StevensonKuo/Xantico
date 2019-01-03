<?php

namespace Xantico\Bootstrap\Basic;

class Label extends Badge
{

    /**
     * @desc constructor, create a badge class directly.
     * @param string $text
     * @param array $vars
     * @param array $attr
     * @return \model\Xantico\basic\Badge
     */
    public function __construct($text = "", $vars = array(), $attr = array())
    {
        parent::__construct($text, $vars, $attr);
        $this->type = "label";
        $this->context = isset ($vars ['Context']) ? $vars ['Context'] : "default";
    }
}


