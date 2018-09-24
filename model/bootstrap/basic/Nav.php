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
     * 建構子
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
        $this->screw       = new Navlet();
    }
    
    /**
     * 渲染（佔位）
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
        $this->setCustomClass($_class);
//         $this->setAttrs(array ("role" => "tablist"));
        
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->text instanceof HtmlTag && $item->text->getTagName() == "li") {
                    continue;
                } else {
                    $_li = new HtmlTag("li");
//                      $_li->setAttrs(array ("role" => "presentation"));
                    if ($key == $this->activeIndex || $item->active == true) { 
                        $_li->setCustomClass("active");
                    }
                    if ($item->disabled == true) { 
                        $_li->setCustomClass("disabled");
                    }
                    
                    if (!empty ($item->url)) {
                        $_a = new HtmlTag("a");
                        $_a->setAttrs(array ("href" => $item->url));
                        if (is_string($item->text)) {
                            $_a->setInnerText($item->text);
                        } else {
                            $_a->setInnerElements($item->text);
                        }
                        
                        $_li->setInnerElements($_a);
                    } else {
                        $_li->setInnerElements($item->text);
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
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                    $_url = isset($items[$i] ['url']) ? $items[$i] ['url'] : "";
                    $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : false;
                    $_disabled = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : false;
                    
                    $items[$i] = new Navlet($_text, $_url, $_active, $_disabled);
                } else if (!($items[$i] instanceof Navlet)) {
                    $items[$i] = new Navlet($items[$i]);
                }
            }
        }
        $this->items = $items;
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

/**
 * @desc trivial class for Nav
 * @author metatronangelo
 *
 */
class Navlet {
    var $text;
    var $url;
    var $active;
    var $disabled;
    
    public function __construct($text = "", $url = "", $active = false, $disabled = false, $align = "") {
        $this->text = $text;
        $this->url = $url;
        $this->active = $active;
        $this->disabled = $disabled; 
    }
}
