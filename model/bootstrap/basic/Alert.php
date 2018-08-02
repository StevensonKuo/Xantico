<?php
namespace model\bootstrap\basic;


use model\bootstrap\basic\Typography;

class Alert extends Typography
{
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:alert", $vars, $attr);
        
        $this->type     = "alert";
        $this->colorSet = isset($vars ['colorSet']) ? $vars ['colorSet'] : "success"; 
        // alert 的 color set 預設為 success, 不為 default/primary
        
        return $this;
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $this->setAttrs(array ("role" => "alert"));
        $this->setCustomClass("alert-" . $this->colorSet);
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
}


