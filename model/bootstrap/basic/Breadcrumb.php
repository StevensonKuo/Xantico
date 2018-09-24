<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Breadcrumb extends Typography 
{
    public $screw; // crumb
    protected $activeIndex; // int
    protected $hideAfter; // boolean; hide levels after actived index.
    
    /**
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("ol:breadcrumb", $vars, $attrs);
        
//          $this->type         = "breadcrumb"; // will be set in parent class.
        $this->activeIndex  = isset ($vars ['activeIndex']) ? $vars ['activeIndex'] : 0;
        $this->hideAfter    = isset ($vars ['hideAfter']) ? $vars ['hideAfter'] : true;
        $this->screw        = new Crumb();
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if ($item->text instanceof HtmlTag && $item->text->getTagName() == "li") {
                    continue;
                } else {
                    $_li = new HtmlTag("li");
//                      $_li->setAttrs(array ("role" => "presentation"));
//                     if ($item->disabled == true) {
//                         $_li->setCustomClass("disabled");
//                     }
                    if ($key == $this->activeIndex || $item->active == true) { 
                        $_li->setCustomClass("active");
                        
                        $_li->setInnerElements($item->text);
                        if ($this->hideAfter == true) {
                            $this->innerElements [] = $_li;
                            break;
                        }
                    } else if (!empty ($item->url)) { // breadcrumb 裡有 active 就沒 a
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
            $this->items = null; // all items passed to inner elements. set to null to avoid render duplicated.
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
     * @desc check if items are instance of <class>Crumb
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items) {
        if (!empty($items)) {
            for ($i = 0; $i < count($items); $i ++) {
                if (is_array ($items[$i])) {
                    $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                    $_url = isset($items[$i] ['url']) ? $items[$i] ['url'] : "#";
                    $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : false;
                    $_disabled = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : false;
                    
                    $items[$i] = new Crumb($_text, $_url, $_active, $_disabled);
                } else if (!($items[$i] instanceof Crumb)) {
                    $items[$i] = new Crumb($items[$i]);
                }
            }
        }
        $this->items = $items;
        return $this;
    }

    /**
     * @desc step forward, active index +1
     */
    public function stepForward ($steps = 1) {
        $_count = !empty($this->items) ? count($this->items)-1 : 0;
        $this->activeIndex = min($_count, max($this->activeIndex + $steps, 0));
        return $this;
    }
    
    /**
     * @desc step backward, active index -1
     */
    public function stepBackward ($steps = 1) {
        $_count = !empty($this->items) ? count($this->items)-1 : 0;
        $this->activeIndex = min($_count, max($this->activeIndex - $steps, 0));
        return $this;
    }
    
    /**
     * @return the $hideAfter
     */
    public function getHideAfter()
    {
        return $this->hideAfter;
    }

    /**
     * @param Ambigous <number, array> $hideAfter
     */
    public function setHideAfter($hideAfter = true)
    {
        $this->hideAfter = $hideAfter;
        return $this;
    }

}

/**
 * @desc breadcrumb 項目用小物件
 * @author metatronangelo
 *
 */
class Crumb {
    var $text;
    var $url;
    var $active;
    var $disabled;
    
    public function __construct($text = "", $url = "#", $active = false, $disabled = false) {
        $this->text = $text;
        $this->url = $url;
        $this->active = $active;
        $this->disabled = $disabled; 
    }
}
