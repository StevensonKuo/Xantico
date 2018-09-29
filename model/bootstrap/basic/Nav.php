<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Nav extends Typography 
{
    public $screw; // Navlet
    
    protected $activeIndex; // int
    protected $style; // string
    protected $isJustified; // boolean
    
    private static $styleArr = array ("tabs", "pills", "stacked", "navbar");
    
    /**
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("ul:nav", $vars, $attrs);
        
        $this->type         = "nav";
        $this->activeIndex  = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : -1;
        $this->style        = isset ($vars ['style']) ? $vars ['style'] : "tabs";
        $this->isJustified  = isset ($vars ['isJustified']) ? $vars ['isJustified'] : false;
        
        $this->screw       = array (
            "text"      => "&nbsp;", 
            "url"       => "", 
            "active"    => false, 
            "disabled"  => false,
            "align"     => ""
        );
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $_class = array ();
        if ($this->style == "navbar") {
            $_class [] = $this->style . "-nav";
        } else if (!empty($this->style)) {
            $_class [] = "nav-" . $this->style;
            if ($this->style == "stacked") $_class [] = "nav-pills";
        }
        
        if ($this->isJustified == true) $_class [] = "nav-justified";
        $this->appendCustomClass($_class);
//         $this->appendAttrs(array ("role" => "tablist"));
        
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item ['text'] instanceof HtmlTag && $item ['text']->getTagName() == "li") {
                    continue;
                } else {
                    $_li = new HtmlTag("li");
//                      $_li->appendAttrs(array ("role" => "presentation"));
                    if ($key == $this->activeIndex || $item ['active'] == true) { 
                        $_li->appendCustomClass("active");
                    }
                    if ($item ['disabled'] == true) { 
                        $_li->appendCustomClass("disabled");
                    }
                    
                    if (!empty ($item ['url'])) {
                        $_a = new HtmlTag("a");
                        $_a->appendAttrs(array ("href" => $item ['url']));
                        if (is_string($item ['text'])) {
                            $_a->setInnerText($item ['text']);
                        } else {
                            $_a->appendInnerElements($item ['text']);
                        }
                        
                        $_li->appendInnerElements($_a);
                    } else {
                        $_li->appendInnerElements($item ['text']);
                    }
                }
                
                $this->innerElements [] = $_li;
            }
            $this->items = null; // clear after pass to inner elements
            
        }
        
        parent::render();
        
        if ($display == true) {
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
     * @desc check if item is instance of Navlet
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::appendItems()
     */
    public function setItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $items[$i] ['text']     = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url']      = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['active']   = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                    $items[$i] ['align']    = isset($items[$i] ['align']) ? $items[$i] ['align'] : $this->screw ['align'];
                    
                } else {
                    $_item ['text']     = $items[$i];
                    $_item ['url']      = $this->screw ['url'];
                    $_item ['active']   = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];
                    $_item ['align']    = $this->screw ['align'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::setItems($items);
        return $this;
    }
    
    /**
     * @desc check if item is instance of Navlet
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::appendItems()
     */
    public function appendItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $items[$i] ['text']     = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                    $items[$i] ['url']      = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                    $items[$i] ['active']   = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                    $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                    
                } else {
                    $_item ['text']     = $items[$i];
                    $_item ['url']      = $this->screw ['url'];
                    $_item ['active']   = $this->screw ['active'];
                    $_item ['disabled'] = $this->screw ['disabled'];
                    $items [$i] = $_item;
                    unset ($_item);
                }
            }
        }
        parent::appendItems($items);
        return $this;
    }
    
    /**
     * @return the $style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @desc pills or tabs
     * @param field_type $style [pills|tabs]
     */
    public function setStyle($style)
    {
        $style = strtolower($style);
        if (!in_array($style, self::$styleArr)) {
            $style = "";
        }
        $this->style = $style;
        return $this;
    }
    
    public function setStyleTabs () {
        $this->style = "tabs";
        return $this;
    }
    
    public function setStylePills () {
        $this->style = "pills";
        return $this;
    }
    
    public function setStyleStacked () {
        $this->style = "stacked";
        return $this;
    }
    
    public function setStyleNavbar () {
        $this->style = "navbar";
        return $this;
    }
    
    /**
     * @return the $isJustified
     */
    public function getIsJustified()
    {
        return $this->isJustified;
    }

    /**
     * @param Ambigous <boolean, array> $isJustified
     */
    public function setIsJustified($isJustified = true)
    {
        $this->isJustified = $isJustified;
        return $this;
    }
}
