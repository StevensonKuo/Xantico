<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;


class Navbar extends Typography 
{
    protected $brand; // header-brand
    protected $bgStyle; // string
    protected $style; // string
    protected $isFluid; // boolean
    protected $isTop; // boolean
    protected $isBottom; // boolean
    protected $collapseButton; // boolean
    protected $activeIndex; // int
    
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("nav:navbar", $vars, $attrs);
        
        $this->type         = "navbar";
        $this->activeIndex  = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0;
        $this->bgStyle      = isset ($vars ['bgStyle']) ? $vars ['bgStyle'] : "";
        $this->style        = isset ($vars ['style']) ? $vars ['style'] : "default";
        $this->brand       = isset ($vars ['brand']) ? $vars ['brand'] : null;
        $this->isFluid      = isset ($vars ['isFluid']) ? $vars ['isFluid'] : false;
        $this->isTop        = isset ($vars ['isTop']) ? $vars ['isTop'] : false;
        $this->collapseButton = isset ($vars ['collapseButton']) ? $vars ['collapseButton'] : false;
    }
    
    /**
     * @desc 
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $_class [] = "navbar-" . $this->style;
        if (!empty($this->bgStyle)) $_class [] = "bg-" . $this->bgStyle;
        if ($this->isTop === "static") $_class [] = "navbar-static-top";
        else if ($this->isTop == true) $_class [] = "navbar-fixed-top";
        if ($this->isBottom == "static") $_class [] = "navbar-static-bottom";
        else if ($this->isBottom == true) $_class [] = "navbar-fixed-bottom";
        $this->setCustomClass($_class);
        
        if ($this->isFluid == true) {
            $_container = new Typography("div:container-fluid");
        } else {
            $_container = new Typography("div:container");
        }
        
        $_navHeader = new Typography("div:navbar-header");
        $_brand = new Typography("a:navbar-brand");
        $_brand->setInnerElements($this->brand);
        
        $_navBody = new Typography("div:navbar-collapse");
        $_navBody->setCustomClass("collapse")
        ->setId();
        
        if ($this->collapseButton == true) {
            $cBtn = new Button();
            $cBtn->truncateClass() // 不要按鈕的預定樣式 
            ->setCustomClass(array ("navbar-toggle", "collapsed"))
            ->setAttrs(array (
                "data-toggle" => "collapse",
                "data-target" => '#' . $_navBody->getId(),
                "data-toggle" => "collapse", 
                "aria-expanded" => "false",
                "aria-controls" => "navbar" 
            ));
            $comment = new Typography("span:sr-only", array("text" => "Toggle navigation"));
            $iconbar = new Typography("span:icon-bar", array ("text" => "\t"));
            $cBtn->setInnerElements(array ($comment, $iconbar, clone $iconbar, clone $iconbar));
            
            $_navHeader->setInnerElements($cBtn);
        }
        
        $_navHeader->setInnerElements($_brand);
        
        if (!empty($this->items)) {
            $_nav = new Nav();
            $_nav->setStyle("navbar")
            ->setActiveIndex($this->activeIndex)
            ->setItems($this->items);
            $this->items = array ();
            
            $_navBody->setInnerElements($_nav);
        }
        
        // anything else putting into, like inline form.
        if(!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if (is_string($ele)) {
                    $textP = new HtmlTag("p");
                    $textP->setCustomClass("navbar-text")->setCdata($ele);
                    $_navBody->setInnerElements($textP);
                } else {
                    if ($ele instanceof HtmlTag) {
                        if (method_exists($ele, "getAlign") && $ele->getAlign() == "right" && !in_array("navbar-right", $ele->getCustomClass())) {
                            $ele->setCustomClass("navbar-right");
                        }
                        if (method_exists($ele, "getTagName") && $ele->getTagName() == "a" && !in_array("navbar-link", $ele->getCustomClass())) {
                            $ele->setCustomClass("navbar-link");
                        }
                        if (method_exists($ele, "getTagName") && $ele->getTagName() == "p" && !in_array("navbar-text", $ele->getCustomClass())) {
                            $ele->setCustomClass("navbar-text");
                        }
                        if (method_exists($ele, "getTagName") && $ele->getTagName() == "button" && !in_array("navbar-btn", $ele->getCustomClass())) {
                            $ele->setCustomClass("navbar-btn");
                        }
                    }
                    $_navBody->setInnerElements($ele);
                }
            }
            $this->innerElements = null;
        } else if (!empty($this->text)) {
            $textP = new HtmlTag("p");
            $textP->setCustomClass("navbar-text")->setText($this->text);
            $_navBody->setInnerElements($textP);
            $this->text = null;
        }
        $_container->setInnerElements(array ($_navHeader, $_navBody));
        $this->setInnerElements($_container);
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }

    /**
     * @param field_type $activeIndex
     */
    public function setActiveIndex($activeIndex)
    {
        $this->activeIndex = $activeIndex;
        return $this;
    }
    
    /**
     * @return the $header
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return the $bgStyle
     */
    public function getBgStyle()
    {
        return $this->bgStyle;
    }

    /**
     * @return the $style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @return the $isFluid
     */
    public function getIsFluid()
    {
        return $this->isFluid;
    }

    /**
     * @return the $isTop
     */
    public function getIsTop()
    {
        return $this->isTop;
    }

    /**
     * @param Ambigous <NULL, array> $header
     */
    public function setBrand($header)
    {
        $this->brand = $header;
        return $this;
    }

    /**
     * @desc default|primary|dark|inverse... 
     * @param Ambigous <boolean, array> $bgStyle
     */
    public function setBgStyle($bgStyle)
    {
        $this->bgStyle = $bgStyle;
        return $this;
    }

    /**
     * @desc default|primary|dark|inverse
     * @param Ambigous <boolean, array> $style
     */
    public function setStyle($style)
    {
        if (empty ($style)) $style = "default";
        $this->style = $style;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $isFluid
     */
    public function setIsFluid($isFluid = true)
    {
        $this->isFluid = $isFluid;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $isTop
     */
    public function setIsTop($isTop = true, $static = false)
    {
        if ($isTop == true && $static == true) $this->isTop = "static";
        else $this->isTop = $isTop;
        return $this;
    }
    
    /**
     * @return the $collapseButton
     */
    public function getCollapseButton()
    {
        return $this->collapseButton;
    }

    /**
     * @param field_type $collapseButton
     */
    public function setCollapseButton($collapseButton = true)
    {
        $this->collapseButton = $collapseButton;
        return $this;
    }
    /**
     * @return the $isBottom
     */
    public function getIsBottom()
    {
        return $this->isBottom;
    }

    /**
     * @param field_type $isBottom
     */
    public function setIsBottom($isBottom = true, $static = false)
    {
        if ($isBottom == true && $static == true) $this->isBottom = "static"; 
        else $this->isBottom = $isBottom;
        
        return $this;
    }



    
}

