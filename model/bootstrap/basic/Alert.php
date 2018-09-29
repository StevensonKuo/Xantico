<?php
namespace model\bootstrap\basic;


use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Alert extends Typography
{
    protected $isDismissible; // boolean
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:alert", $vars, $attr);
        
        $this->type             = "alert";
        $this->isDismissible    = isset($vars ['isDismissible']) ? $vars ['isDismissible'] : false;
        $this->context         = !empty($this->context) ? $this->context : "success"; 
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $this->attrs ["role"] = "alert";
        $this->customClass [] = "alert-" . $this->context;
        
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if (method_exists($ele, "getTagName") && $ele->getTagName() == "a" && $this->type == "alert") {
                    if (!in_array("alert-link", $ele->getCustomClass())) {
                        $ele->appendCustomClass("alert-link");
                    }
                }
            }
        }
        
        if ($this->isDismissible == true) {
            $this->customClass [] = "alert-dismissible";
            $closeBtn = new HtmlTag("button");
            $closeBtn->appendCustomClass("close");
            $closeBtn->appendAttrs(array ("data-dismiss" => "alert", "aria-label" => "Close"));
            $icon = new HtmlTag("span", array ("aria-hidden" => "true"));
            $icon->setCdata("&times;");
            $closeBtn->appendInnerElements($icon);
            array_unshift($this->innerElements, $closeBtn);
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $withCloseButton
     */
    public function getIsDismissible()
    {
        return $this->isDismissible;
    }

    /**
     * @param Ambigous <boolean, array> $withCloseButton
     */
    public function setIsDismissible($withCloseButton = true) 
    {
        $this->isDismissible = $withCloseButton;
        return $this;
    }

    
}


