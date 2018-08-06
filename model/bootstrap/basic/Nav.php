<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Nav extends Typography 
{
    public $screw; // Navlet
    
    protected $activeIndex; // int
    protected $style;
    
    private static $styleArr = array ("tabs", "pills");
    
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
        $this->style        = isset ($vars ['style']) ? $vars ['style'] : "";
        $this->screw       = new Navlet();
        
        return $this;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $_class = array ();
        if (!empty($this->style)) $_class [] = "nav-" . $this->style;
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
            unset ($this->items); //已經都整理好交給 innerElements 了, 不用再 pass 給 Typograph 的 render 處理
        }
        
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
     * @desc 需要檢查是不是 navlet 的物件.
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
     * @desc 樣式
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


}

/**
 * @desc nav 項目用小物件
 * @author metatronangelo
 *
 */
class Navlet {
    var $text;
    var $url;
    var $active;
    var $disabled;
    
    public function __construct($text = "", $url = "", $active = false, $disabled = false) {
        $this->text = $text;
        $this->url = $url;
        $this->active = $active;
        $this->disabled = $disabled; 
    }
}
