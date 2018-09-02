<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Input;

class Select extends Input 
{
    public function __construct($options = array (), $vars = array (), $attr = array ())
    {
        parent::__construct("select", $vars, $attr);
        $this->options = $options;
        
    }

}



