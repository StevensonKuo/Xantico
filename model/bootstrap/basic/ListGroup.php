<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class ListGroup extends Typography 
{
    public $screw;
    
    public static $ITEM_HEADING_SIZE = 4;
    
    private static $modeArr = array ("button", "anchar", "");
    
    
    /**
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($vars = array (), $attrs = array ())
    {
        
        parent::__construct("ul:list-group", $vars, $attrs);
        
        $this->screw    = array (
            "text"      => "&nbsp;",
            "url"       => "",
            "active"    => false,
            "disabled"  => false,
            "heading"   => "",
            "context"   => ""
        );
    }
    
    /**
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
                if (empty($item ['url']) && $itemTag == "a") {
                    $item ['url'] = "#";
                } else if (!empty($item ['url'])) { // if thera have been set url, force set the tag to <a/>.
                    $this->setTagName("div");
                    $itemTag = "a";
                }
                
                $_li = new HtmlTag($itemTag);
                $_li->appendCustomClass("list-group-item");
                if ($item ['active'] == true) { 
                    $_li->appendCustomClass("active");
                }
                if ($item ['disabled'] == true) { 
                    $_li->appendCustomClass("disabled");
                }
                if ($itemTag == "a" && !empty($item ['url'])) {
                    $_li->appendAttrs(array ("href" => $item ['url']));
                }
                if (!empty($item ['context']) && in_array($item ['context'], self::$contextArr)) {
                    $_li->appendCustomClass("list-group-item-" . $item ['context']);
                }
                if (!empty($item ['heading'])) {
                    $_heading = new HtmlTag("h" . self::$ITEM_HEADING_SIZE);
                    $_heading->appendCustomClass("list-group-item-heading")
                    ->setInnerText($item ['heading']);
                    $_paragraph = new HtmlTag("p");
                    $_paragraph->setInnerText($item ['text'])
                    ->appendCustomClass("list-group-item-text");
                    $item ['text'] = array ($_heading, $_paragraph);
                }
                
                if (is_string($item ['text'])) {
                    $_li->setInnerText($item ['text']);
                } else {
                    $_li->appendInnerElements($item ['text']);
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
     * @see \model\bootstrap\basic\Typography::appendItems()
     */
    public function setItems($items) {
        if (!is_array($items)) $items = array ($items);
        for ($i = 0; $i < count($items); $i ++) {
            if (is_array ($items[$i])) {
                $items[$i] ['text']     = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                $items[$i] ['url']      = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                $items[$i] ['active']   = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                $items[$i] ['heading']  = isset($items[$i] ['heading']) ? $items[$i] ['heading'] : $this->screw ['heading'];
                $items[$i] ['context']  = isset($items[$i] ['context']) ? strtolower($items[$i] ['context']) : $this->screw ['context'];
            } else {
                $_item ['text']     = $items[$i];
                $_item ['url']      = $this->screw ['url'];
                $_item ['active']   = $this->screw ['active'];
                $_item ['disabled'] = $this->screw ['disabled'];
                $_item ['heading']  = $this->screw ['heading'];
                $_item ['context']  = $this->screw ['context'];
                
                $items[$i] = $_item;
                unset ($_item);
            }
        }
        
        parent::setItems($items);
        return $this;
    }
    
    /**
     * @desc check if items are instances of Listle.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::appendItems()
     */
    public function appendItems($items) {
        if (!is_array($items)) $items = array ($items);
        for ($i = 0; $i < count($items); $i ++) {
            if (is_array ($items[$i])) {
                $items[$i] ['text'] = isset($items[$i] ['text']) ? $items[$i] ['text'] : $this->screw ['text'];
                $items[$i] ['url'] = isset($items[$i] ['url']) ? $items[$i] ['url'] : $this->screw ['url'];
                $items[$i] ['active'] = isset($items[$i] ['active']) ? $items[$i] ['active'] : $this->screw ['active'];
                $items[$i] ['disabled'] = isset($items[$i] ['disabled']) ? $items[$i] ['disabled'] : $this->screw ['disabled'];
                $items[$i] ['heading'] = isset($items[$i] ['heading']) ? $items[$i] ['heading'] : $this->screw ['heading'];
                $items[$i] ['context'] = isset($items[$i] ['context']) ? strtolower($items[$i] ['context']) : $this->screw ['context'];
            } else {
                $_item ['text']     = $items[$i];
                $_item ['url']      = $this->screw ['url'];
                $_item ['active']   = $this->screw ['active'];
                $_item ['disabled'] = $this->screw ['disabled'];
                $_item ['heading']  = $this->screw ['heading'];
                $_item ['context']  = $this->screw ['context'];
                
                $items[$i] = $_item;
                unset ($_item);
            }
        }
        
        parent::appendItems($items);
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

