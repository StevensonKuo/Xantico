<?php

namespace Xantico\Bootstrap\Basic;

class Select extends InputInterface
{
    public function __construct($options = array(), $vars = array(), $attr = array())
    {
        parent::__construct("select", $vars, $attr);
        $this->options = $options;

    }

}



