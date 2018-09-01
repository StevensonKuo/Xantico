<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class ListGroup extends Typography 
{
    public $screw; // listle
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("ul:list-group", $vars, $attrs);
        
        $this->type         = "list-group";
        $this->screw        = new Listle();
        
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if (!empty($item->url)) {
                    $this->setTagName("div");
                    $itemTag = "a";
                } else {
                    $itemTag = "li";
                }
                
                $_li = new HtmlTag($itemTag);
                $_li->setCustomClass("list-group-item");
                if ($item->active == true) { 
                    $_li->setCustomClass("active");
                }
                if ($item->disabled == true) { 
                    $_li->setCustomClass("disabled");
                }
                if ($itemTag == "a" && !empty($item->url)) {
                    $_li->setAttrs(array ("href" => $item->url));
                }
                if (!empty($item->heading)) {
                    $_heading = new HtmlTag("h" . Listle::$headingSize);
                    $_heading->setCustomClass("list-group-item-heading")
                    ->setInnerText($item->heading);
                    $_paragraph = new HtmlTag("p");
                    $_paragraph->setInnerText($item->text)
                    ->setCustomClass("list-group-item-text");
                    $item->text = array ($_heading, $_paragraph);
                }
                
                if (is_string($item->text)) {
                    $_li->setInnerText($item->text);
                } else {
                    $_li->setInnerElements($item->text);
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
     * @desc 需要檢查是不是 listle 的物件. 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items = array ()) {
        if (!is_array($items)) $items = array ($items);
        for ($i = 0; $i < count($items); $i ++) {
            if (is_array ($items[$i])) {
                $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                $_url = isset($items[$i] ['url']) ? $items[$i] ['url'] : "";
                $_heading = isset($items[$i] ['heading']) ? $items[$i] ['heading'] : "";
                $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : false;
                $_disabled = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : false;
                
                $items[$i] = new Listle($_text, $_url, $_heading, $_active, $_disabled);
            } else if (!($items[$i] instanceof Listle)) {
                $items[$i] = new Listle($items[$i]); 
            }
        }
        
        $this->items = $items;
        return $this;
    }
}

/**
 * @desc list group 項目用小物件
 * @author metatronangelo
 *
 */
class Listle { 
    var $text;
    var $url;
    var $heading;
    var $active;
    var $disabled;
    
    static $headingSize = 4;
    
    public function __construct($text = "", $url = "", $heading = "", $active = false, $disabled = false) {
        $this->text = $text;
        $this->url = $url;
        $this->heading = $heading;
        $this->active = $active;
        $this->disabled = $disabled; 
    }
}
