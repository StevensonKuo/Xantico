<?php
namespace model\bootstrap\basic;
require_once 'model/bootstrap/basic/Badge.php';

use model\bootstrap\basic\Badge; 

class Label extends Badge
{
    
    /**
     * @desc contructor
     * @param string $text
     * @param string $colorSet [defualt|success|info|warning|danger...]
     */
    public function __construct($text = "", $vars = array (), $attr = array ())
    {
        parent::__construct($text, $vars, $attr);
        
        $this->type     = "label";
        $this->text     = !empty($text) ? $text : "label";
        $this->colorSet = empty($this->colorSet) ? "default" : $this->colorSet;
        
        return $this;
    }
}


