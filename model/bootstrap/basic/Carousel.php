<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Carousel extends Typography  
{
    protected $activeIndex; // int
    protected $withIndicator; // boolean
    protected $withControl; // boolean
    protected $interval; // int. ms
    
    public $screw; // Slidle
    
    const BOOTSTRAP_CAROUSEL_NEXT = "Next";
    const BOOTSTRAP_CAROUSEL_PREVIOUS = "Previous";
    
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("div:carousel", $vars, $attrs);
        
        $this->type         = "carousel";
        $this->activeIndex  = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0; // Carousel 一定要有一個 active不然不會動, 和 nav 等不一樣
        $this->withIndicator= isset ($vars ['withIndicator']) ? $vars ['withIndicator'] : true;
        $this->withControl  = isset ($vars ['withControl']) ? $vars ['withControl'] : true;
        $this->screw        = new Slidle();
        
        return $this;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $this->setId();
        $this->setCustomClass("slide")
        ->setAttrs(array ("data-ride" => "carousel"));
        
        if ($this->withIndicator == true) {
            $_indicator = new HtmlTag("ol");
            $_indicator->setCustomClass("carousel-indicators");
        }
        
        $_body = new HtmlTag("div");
        $_body->setCustomClass("carousel-inner");
        $_body->setAttrs(array ("role" => "listbox"));
        
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                $_div = new HtmlTag("div");
                $_div->setCustomClass("item");
                
                if ($item->active == true) { 
                    $_div->setCustomClass("active");
                }
                
                $_img = new Image();
                $_img
                ->setAttrs(array ("data-src" => $item->source))
//                 ->setSource($item->source)
                ->setAlt($item->text);
                $_div->setInnerElements($_img);
                if (!empty($item->text)) {
                    $_textDiv = new HtmlTag("div");
                    $_textDiv->setCustomClass(array ("carousel-caption", "d-none", "d-md-block"));
                    $_textDiv->setInnerElements($item->text);
                    
                    $_div->setInnerElements($_textDiv);
                }
                
                $_body->setInnerElements($_div);
                
                if ($this->withIndicator == true) {
                    // @todo indicator 不能點, 不知道為什麼... QQ
                    $_li = new HtmlTag("li");
                    $_li->setAttrs(array ("data-target" => $this->id, "data-slide-to" => $key))
                    ->setText("\t");
                    
                    if ($item->active == true) {
                        $_div->setCustomClass("active");
                        $_li->setCustomClass("active");
                    }
                    
                    $_indicator->setInnerElements($_li);
                }
            }
            unset ($this->items); //已經都整理好交給 innerElements 了, 不用再 pass 給 Typograph 的 render 處理
        }
        
        if ($this->withIndicator == true) {
            $this->innerElements = array($_indicator, $_body);
        } else {
            $this->innerElements = array($_body);
        }
        
        if ($this->withControl == true) {
            $_previous = new HtmlTag("a");
            $_previous->setAttrs(array ("href" => "#" . $this->getId(), "role" => "button", "data-slide" => "prev"))
            ->setCustomClass(array("left", "carousel-control"));
            $_icon = new Icon("chevron-left");
            $_icon->setAttrs(array ("aria-hidden" => "true"));
            $_comment = new Typography("span:sr-only", array ("text" => self::BOOTSTRAP_CAROUSEL_PREVIOUS));
            $_previous->setInnerElements(array ($_icon, $_comment));
            
            $_next = clone $_previous;
            $_next->setAttrs(array ("data-slide" => "next")) // will overwrite old attr.
            ->truncateClass()
            ->setCustomClass(array ("right", "carousel-control"));
            $_next->getElement(0)->setIcon ("chevron-right");
            $_next->getElement(1)->setText (self::BOOTSTRAP_CAROUSEL_NEXT);
            
            $this->setInnerElements($_previous, $_next);
        }
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
 
    /**
     * @desc 需要檢查是不是 listle 的物件. 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $_source = isset($items[$i] ['source']) ? $items[$i] ['source'] : "";
                    $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                    $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : "";
                    
                    $items[$i] = new Slidle($_source, $_text, $_active);
                } else if (!($items[$i] instanceof Slidle)) {
                    unset ($items[$i]); // 一定要 image 所以無法成為內部元素.
                }
            }
        }
        $this->items = $items;
        return $this;
    }
    
    /**
     * @return the $withIndicator
     */
    public function getWithIndicator()
    {
        return $this->withIndicator;
    }

    /**
     * @return the $withControl
     */
    public function getWithControl()
    {
        return $this->withControl;
    }

    /**
     * @param field_type $withIndicator
     */
    public function setWithIndicator($withIndicator = true)
    {
        $this->withIndicator = $withIndicator;
        return $this;
    }

    /**
     * @param field_type $withControl
     */
    public function setWithControl($withControl = true)
    {
        $this->withControl = $withControl;
        return $this;
    }
    
    /**
     * @return the $activeIndex
     */
    public function getActiveIndex()
    {
        return $this->activeIndex;
    }

    /**
     * @param Ambigous <number, array> $activeIndex
     */
    public function setActiveIndex($activeIndex = 0)
    {
        $this->activeIndex = intval($activeIndex);
        return $this;
    }


}

/**
 * @desc carousel 項目用小物件
 * @author metatronangelo
 *
 */
class Slidle { 
    var $source;
    var $text;
    var $active;
    
    public function __construct($source = "", $text = "", $active = false) {
        $this->source = $source;
        $this->text = $text;
        $this->active = $active;
    }
}
