<?php
namespace model\bootstrap\basic;


use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Alert extends Typography
{
    protected $withCloseButton; // boolean
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:alert", $vars, $attr);
        
        $this->type     = "alert";
        $this->withCloseButton = isset($vars ['withCloseButton']) ? $vars ['withCloseButton'] : false;
        $this->colorSet = isset($vars ['colorSet']) ? $vars ['colorSet'] : "success"; 
        // alert 的 color set 預設為 success, 不為 default/primary
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $this->setAttrs(array ("role" => "alert"));
        $this->setCustomClass("alert-" . $this->colorSet);
        
        if ($this->withCloseButton == true) {
            $this->setCustomClass("");
            
            $closeBtn = new Button ();
            $closeBtn->setCustomClass("close");
            $closeBtn->setAttrs(array ("data-dismiss" => "alert", "aria-label" => "Close"));
            
            $icon = new HtmlTag("span", array ("text" => "&times;"), array ("aria-hidden" => "true"));
            
            $closeBtn->setInnerElements($icon);
            $this->setInnerElements($closeBtn); // @todo 目前順序是放在後面, 教學是放在前面, 可能會改
        }
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    /**
     * @return the $withCloseButton
     */
    public function getWithCloseButton()
    {
        return $this->withCloseButton;
    }

    /**
     * @param Ambigous <boolean, array> $withCloseButton
     */
    public function setWithCloseButton($withCloseButton = true) 
    {
        $this->withCloseButton = $withCloseButton;
        return $this;
    }

    
}


