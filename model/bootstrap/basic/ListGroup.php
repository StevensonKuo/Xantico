<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class ListGroup extends Typography 
{
    private static $modeArr = array ("button", "anchar", "");
    
    public $screw; // listle
    
    /**
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
        // decide parent tag.
        if ($this->mode == "anchor") {
            $this->setTagName("div");
            $itemTag = "a";
        } else if ($this->mode == "button") {
            $this->setTagName("div");
            $itemTag = "button";
        } else {
            $itemTag = "li";
        }
        
        if (!empty($this->items)) {
            foreach ($this->items as $key => $item) {
                if (empty($item->url) && $itemTag == "a") {
                    $item->url = "#";
                } else if (!empty($item->url)) { // if thera have been set url, force set the tag to <a/>.
                    $this->setTagName("div");
                    $itemTag = "a";
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
                if (!empty($item->context) && in_array($item->context, self::$contextualColorArr)) {
                    $_li->setCustomClass("list-group-item-" . $item->context);
                }
                if (!empty($item->heading)) {
                    $_heading = new HtmlTag("h" . Listle::$HEADING_SIZE);
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
            $this->items = null;
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
 
    /**
     * @desc check if items are instances of Listle.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items = array ()) {
        if (!is_array($items)) $items = array ($items);
        for ($i = 0; $i < count($items); $i ++) {
            if (is_array ($items[$i])) {
                $_text = isset($items[$i] ['text']) ? $items[$i] ['text'] : 0;
                $_url = isset($items[$i] ['url']) ? $items[$i] ['url'] : "";
                $_active = isset($items[$i] ['active']) ? $items[$i] ['active'] : false;
                $_disabled = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : false;
                $_heading = isset($items[$i] ['heading']) ? $items[$i] ['heading'] : "";
                $_context = isset($items[$i] ['context']) ? strtolower($items[$i] ['context']) : "";
                
                $items[$i] = new Listle($_text, $_url, $_active, $_disabled, $_heading, $_context);
            } else if (!($items[$i] instanceof Listle)) {
                $items[$i] = new Listle($items[$i]); 
            }
        }
        
        $this->items = $items;
        return $this;
    }
    
    /**
     * @desc mode [regular|button|anchor]
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setMode()
     */
    public function setMode($mode = "") {
        $mode = strtolower($mode);
        if (in_array($mode, self::$modeArr)) {
            $this->mode = $mode;
        }
        return $this;
    }
    
    /**
     * @desc quick set mode to button
     * @return \model\bootstrap\basic\ListGroup
     */
    public function setModeButton () {
        $this->mode = "button";
        return $this;
    }

    /**
     * @desc quick set mode to anchor
     * @return \model\bootstrap\basic\ListGroup
     */
    public function setModeAnchor () {
        $this->mode = "anchor";
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
    var $active;
    var $disabled;
    var $heading;
    var $context;
    
    static $HEADING_SIZE = 4; // h1 ~ h6
    
    public function __construct($text = "", $url = "", $active = false, $disabled = false, $heading = "", $context = "") {
        $this->text = $text;
        $this->url = $url;
        $this->active = $active;
        $this->disabled = $disabled; 
        $this->heading = $heading;
        $this->context = strtolower($context);
    }
}
