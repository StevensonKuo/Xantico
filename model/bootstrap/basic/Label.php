<?php
namespace model\bootstrap\basic;
// require_once 'model/bootstrap/basic/Badge.php';

use model\bootstrap\basic\Badge; 

class Label extends Badge 
{
    
    /**
     * @desc constructor, create a badge class directly.
     * @param string $text
     * @param array $vars
     * @param array $attr
     * @return \model\bootstrap\basic\Badge
     */
    public function __construct($text = "", $vars = array (), $attr = array ())
    {
        parent::__construct($text, $vars, $attr);
        $this->type     = "label";
        $this->context = isset ($vars ['Context']) ? $vars ['Context'] : "default";
    }
}


