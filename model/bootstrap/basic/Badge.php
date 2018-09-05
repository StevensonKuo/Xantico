<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Badge extends Typography
{
    
    /**
     * @desc contructor
     * @param string $text
     * @param string $colorSet [defualt|success|info|warning|danger...]
     * @param string $align [right|left]
     */
    public function __construct($text = "", $vars = array (), $attr = array ())
    {
        parent::__construct("span", $vars, $attr);
        
        $this->type     = "badge";
        $this->text     = !empty($text) ? $text : "badge";
        $this->align    = "right"; // default alignment is in right.
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class [] = $this->type;
        if (!empty($this->colorSet)) $class [] = $this->type . '-' . $this->colorSet;
        if (!empty($this->align)) $class [] = $this->type . '-' . $this->align;
        
        $this->customClass = $class; // 本來用 set 的結果就一直產生 class 的累積
        $this->setInnerText($this->text);
                
        $html = parent::render();
        
        $this->html = $html;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
}


