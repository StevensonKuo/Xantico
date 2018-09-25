<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;

class Typography extends \model\bootstrap\HtmlTag 
{
    protected $type;    // string
    protected $id;      // string
    protected $colorSet;// string
    protected $text;    // string
    protected $textColorSet; // string
    protected $caption; // string; !important different from text/innerText
    protected $title;// string
    protected $align;   // string
    protected $verticalAlign; // string
    protected $size; // int
    protected $border; // int
    protected $items; // array 
    protected $textClass; // array 
    protected $jQuery; // string
    protected $grid; // int or array(), Bootstrap Grids System
    protected $mode; // for one more type/mode to switch what you want.
    protected $embedResponsive; // ratio, 16by9 or 4by3
    
    protected static $alignArr = array("right", "left", "center", "");
    protected static $vAlignArr = array("top", "middle", "bottom", "");
    protected static $contextualColorArr = array ("success", "default", "primary", "danger", "warning", "info");
    protected static $embedTagsArr = array("iframe", "embed", "video", "object");
    
    private static $instanceCounter = 0; // int
    
    public static $AUTO_ID = false;
    

    /**
     * @param string $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($type, $vars = array (), $attrs = array ())
    {
        $divX = explode(":", $type); // div:row, div:badge, div:page-header etc... 
        $tagName = isset($divX [0]) ? $divX [0] : (isset($divX [1]) ? "div" : $type);
        
        parent::__construct($tagName, $attrs);
        
        if (isset($divX [1])) {
            $type = $divX [1];
            $this->setCustomClass($type);
        }
        
        // other attributes initialize.
        ++self::$instanceCounter;
        if (self::$AUTO_ID == true && !isset($vars['id'])) {
            $this->id = self::generateTagId($this);
        } else if (isset($vars['id']) && !empty($vars['id'])) {
            $this->id = $vars ['id'];
        }
        
        $this->type         = strtolower($type);
        $this->colorSet     = isset($vars['colorSet']) ? $vars['colorSet'] : "";
        $this->text         = isset($vars['text']) ? $vars ['text'] : "";
        $this->textColorSet = isset($vars['textColorSet']) ? $vars ['textColorSet'] : "";
        $this->caption      = isset($vars ['caption']) ? $vars ['caption'] : "";
        $this->title        = isset($vars ['title']) ? $vars ['title'] : "";
        $this->align        = isset($vars ['align']) ? $vars ['align'] : "";
        $this->size         = isset($vars ['size']) ? $vars ['size'] : 0;
        $this->border       = isset($vars ['border']) ? $vars ['border'] : 0;
        $this->items        = isset($vars ['items']) ? (is_array($vars ['items']) ? $vars ['items'] : array ($vars ['items'])) : array ();
        $this->textClass    = isset($vars ['textClass']) ? (is_array($vars ['textClass']) ? $vars ['textClass'] : array ($vars ['textClass'])) : array ();
        $this->grid         = isset($vars ['grid']) ? $vars ['grid'] : null;
        $this->mode         = isset($vars ['mode']) ? $vars ['mode'] : null;
        $this->embedResponsive
                            = isset ($vars ['embedResponsive']) ? $vars ['embedResponsive'] : "";
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->items)) { // ol/ul/select
            if (in_array ($this->type, array ("ul", "ol", "select", "navi", "dropdown"))) {
                foreach ($this->items as $item) {
                    if ($item instanceof HtmlTag && $item->getTagName() == "li") {
                        // if the element are tag li already, it doesn't modify it.
                        $this->innerElements [] = $item;
                    } else {
                        $_li = new HtmlTag("li");
                        $_li->setInnerElements(array ($item));
                        $this->innerElements [] = $_li;
                        unset ($_li);
                    }
                }
            } else {
                $this->setInnerElements($this->items);
            }
        }
        
        if (!empty($this->id)) $this->setAttrs(array ("id" => $this->id)); // 合併 id attr
        $this->innerText = isset($this->text) && !empty($this->text) ? $this->text : $this->innerText;
        
        if (!empty($this->grid)) { // handle grids system.
            if (is_array($this->grid)) {
                try {
                    if (!empty($this->grid)) {
                        foreach ($this->grid as $grid) {
                            $this->customClass [] = "col-" . $grid [0] . "-" . $grid [1];
                        }
                    } else {
                        $this->customClass [] = "col";
                    }
                } catch (\Exception $e) {
                    $this->errMsg = "Tag [{$this->tagName}] occurs error in operating grids: " . $e->getMessage();
                }
            } else {
                $this->customClass [] = "col-md-" . $this->grid;
            }
        }
        
        if (!empty($this->embedResponsive)) {
            $embedRatio = explode(":", $this->embedResponsive);
            $this->customClass [] = "embed-responsive";
            $this->customClass [] = "embed-responsive-" . join("by", $embedRatio);    
        }
        
        // @todo scan all innerElements, if you want to do any operation to those childs, add it here.
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                // dropdown issue, if this dropdown is not a button-group and it's type not in class yet.
                if ($ele instanceof HtmlTag) {
                    if (method_exists($ele, "getType") && method_exists($ele, "getMode")) {
                        $_type = $ele->getType();
                        $_mode = $ele->getMode ();
                        if (($_type == "dropdown" || $_type == "dropup") && $_mode != "button" && !in_array($_type, $this->customClass)) {
                            $this->customClass [] = $_type;
                        }
                    }
                    
                    if (!empty($this->embedResponsive) 
                        && !in_array("embed-responsive-item", $ele->getCustomClass())
                        && in_array($ele->getTagName(), self::$embedTagsArr)) {
                            $ele->setCustomClass("embed-responsive-item");
                    }
                }
            }
        }
        
        parent::render();
        
        // gathering jQuery scripts.
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if (empty($ele)) continue;
                if ($ele instanceof Typography && method_exists($ele, "getJQuery") && !empty($ele->getJQuery ())) {
                    $this->jQuery = (!empty($this->jQuery) ? $this->jQuery . "\n" : "" ) . trim($ele->getJQuery ());
                }
            }
        }
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * magic function to string.
     *
     * @return string
     */
    function __toString()
    {
        if ($this->html) {
            return $this->html;
        } else {
            try {
                return $this->render();
            } catch (\Exception $e) {
                return "";
            }
        }
    }

    /**
     *
     * @param string $border            
     */
    public function setBorder($border)
    {
        $this->border = $border;
        return $this;
    }

    /**
     *
     * @return the $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @desc HTML ID. auto-generating if not specified.
     * @param unknown $id
     * @return \model\bootstrap\basic\Typography
     */
    public function setId($id = "")
    {
        if (empty($id) && empty($this->id)) {
            $this->id = self::generateTagId($this);
        } else {
            $this->id = $id;
        }
        
        return $this;
    }
    
    /**
     * @desc return id value.
     * @return string id;
     */
    public function getId () {
        return $this->id;
    }

    /**
     * @return the $jQuery
     */
    public function getJQuery()
    {
        return $this->jQuery;
    }
    
    /**
     * 
     * @param string $jquery
     * @return unknown
     */
    public function setJQuery($jquery = "")
    {
        $this->jQuery .= $jquery . "\n";
    }
    
    /**
     * text/title setter.
     * @param string $text
     * @return \Bootstrap\Aceadmin\Typography
     */
    public function setText ($text) {
        $this->text = $text;
        return $this;
    }
    
    /**
     * title setter.
     * @param string $title
     * @return \Bootstrap\Aceadmin\Typography
     */
    public function setTitle ($title) {
        $this->title = $title;
        return $this;
    }
    
    
    /**
     * @desc for ol,ul,select, navi... items are different from innerElements that will be decorated before input into inner elements.
     * @param array $items
     * @return \model\bootstrap\basic\Typography
     */
    public function setItems ($items) {
        if (empty($items)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $items = func_get_args();
        } else {
            if (!is_array($items)) $items = array ($items);
        }
        
        if ($this->items) $this->items = array_merge($this->items, $items);
        else $this->items = $items;
        return $this;
    }
     
    /**
     * @desc set itmes 不 merge 的版本.
     * @param array $items
     * @return \model\bootstrap\hplus\Typography
     */
    public function assignItems ($items = array ()) {
        if (!is_array($items)) $items = array ($items);
        $this->items = $items;
        
        return $this;
    }
    
    public function truncateItems () {
        $this->items = array ();
        
        return $this;
    }
    
    /**
     * @return the $caption
     */
    public function getCaption()
    {
        return $this->caption;
    }
    
    /**
     * @param field_type $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        return $this;
    }
    /**
     * @return the $attrs
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @param Ambigous <multitype:, array> $attrs
     */
    public function setAttrs($attrs =  array ())
    {
        if (!is_array($attrs)) $attrs = array ($attrs);
        if ($this->attrs && is_array($this->attrs)) $this->attrs = array_merge($this->attrs, $attrs);
        else $this->attrs = $attrs;
        
        return $this;
    }
    /**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return the $colorSet
     */
    public function getColorSet()
    {
        return $this->colorSet;
    }

    /**
     * @return the $textColorSet
     */
    public function getTextColorSet()
    {
        return $this->textColorSet;
    }

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return the $align
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @return the $size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return the $border
     */
    public function getBorder()
    {
        return $this->border;
    }

    /**
     * @return the $items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return the $textClass
     */
    public function getTextClass()
    {
        return $this->textClass;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = strtolower($type);
        return $this;
    }

    /**
     * @todo list all color scene
     * @desc set up scene color.
     * @param Ambigous <string, array> $colorSet
     */
    public function setColorSet($colorSet)
    {
        $this->colorSet = strtolower($colorSet);
        return $this;
    }
    
    // contextual class setter start.
    public function setContextualClassSuccess () {
        $this->colorSet = "success";
        return $this;
    }
    
    public function setContextualClassInfo () {
        $this->colorSet = "info";
        return $this;
    }
    
    public function setContextualClassWarning () {
        $this->colorSet = "warning";
        return $this;
    }
    
    public function setContextualClassDanger () {
        $this->colorSet = "danger";
        return $this;
    }
    
    public function setContextualClassPrimary () {
        $this->colorSet = "primary";
        return $this;
    }
    
    public function setContextualClassDefault () {
        $this->colorSet = "default";
        return $this;
    }
    // contextual class setter end.
    
    /**
     * @param Ambigous <string, array> $textColorSet
     */
    public function setTextColorSet($textColorSet)
    {
        $this->textColorSet = $textColorSet;
        return $this;
    }

    /**
     * @desc universal alignment [left|center|right]
     * @param Ambigous <string, array> $align
     */
    public function setAlign($align)
    {
        $align = strtolower($align);
        if (!in_array($align,  self::$alignArr)) {
            $align = "";
            $this->setErrMsg("[Warning] You set a wrong alignment: ". $align); // todo formatting err msg.
        }
        $this->align = $align;
        return $this;
    }
    
    public function setAlignLeft () {
        $this->verticalAlign = "left";
        return $this;
    }
    
    public function setAlignCenter () {
        $this->verticalAlign = "center";
        return $this;
    }
    
    public function setAlignRight () {
        $this->verticalAlign = "right";
        return $this;
    }
    
    /**
     * @param Ambigous <string, array> $size
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
    
    public function setSizeLg() {
        $this->size = "lg";
        return $this;
    }

    public function setSizeMd() {
        $this->size = "md";
        return $this;
    }
    
    public function setSizeSm() {
        $this->size = "sm";
        return $this;
    }
/**
     * @param Ambigous <multitype:, array, multitype:array > $textClass
     */
    public function setTextClass($textClass = array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $textClass = func_get_args();
        } else {
            if (!is_array($textClass)) $textClass = array ($textClass);
        }
        
        if ($this->textClass && is_array($this->textClass)) $this->textClass = array_merge($this->textClass, $textClass);
        else $this->textClass = $textClass;
        
        return $this;
    }
    /**
     * @return the $instanceCounter
     */
    public static function getInstanceCounter()
    {
        return Typography::$instanceCounter;
    }
    /**
     * @return the $grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param Ambigous <NULL, array> $grid
     */
    public function setGrid($grid)
    {
        $this->grid = $grid;
        return $this;
    }

    /**
     * @desc 產生標籤的自動 id (用計數器)
     * @return string
     */
    protected static function generateTagId ($obj) {
        $namespace = explode("\\", get_class($obj));
        $className = isset($namespace [count($namespace)-1]) ? $namespace [count($namespace)-1] : str_replace(__NAMESPACE__, "", __CLASS__);
        
        return strtolower($className) . self::$instanceCounter;
    }
    
    /**
     * @return the $mode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param field_type $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @desc a search method like DOM does.
     * @desc use "%" to search a $keyword Xantico classes. like "%PageHeader" or "%ProgressBar"
     * @param unknown $keyword
     * @return array 
     */
    public function search ($keyword) {
        $keyword = trim(strtolower($keyword));
        $results = array ();
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if ($ele instanceof HtmlTag) {
                    if (substr($keyword, 0, 1) == ".") {
                        if (in_array($keyword, $ele->getCustomClass())) {
                            $results [] = $ele;
                        }
                    } else if (substr($keyword, 0, 1) == "#") {
                        if ($ele instanceof Typography && $ele->getId() == $keyword) {
                            $results [] = $ele;
                        } else {
                            foreach ($ele->getAttrs() as $key => $attr) {
                                if ($key == "id" && $keyword == $attr) {
                                    $results [] = $ele;
                                }
                            }
                        }
                    } else if (substr($keyword, 0, 1) == "%") {
                        $haystack = explode("\\", strtolower(get_class($ele)));
                        if (isset($haystack [@count($haystack)-1]) && "%".$haystack [@count($haystack)-1] == $keyword) {
                            $results [] = $ele;
                        }
                    } else if ($keyword == $ele->getTagName()) {
                        $results [] = $ele;
                    }
                    
                    // only innerElements will be searched, else like items and grids will coming later.
                    if (!empty($ele->getInnerElements()) && method_exists($ele, "search")) {
                        $innerResults = $ele->search($keyword);
                        if ($innerResults != null) {
                            $results = array_merge($results, $innerResults);
                        }
                    }
                } // end of ele instance of HtmlTag
                
            } /// end of foreach ele
        }
        
        if (!empty($results)) {
            return $results;
        } else {
            return array ();
        }
    }

    /**
     * @desc get item by index.
     * @param unknown $index
     * @return unknown|NULL
     */
    public function getItem($index) {
        if (isset ($this->items [$index])) {
            return $this->items [$index];
        } else {
            return null;
        }
    }
    
    /**
     * @desc set item by index.
     * @param unknown $index
     * @param unknown $ele
     * @return \model\bootstrap\HtmlTag
     */
    public function setItem($index, $item) {
        $this->items [$index] = $item;
        return $this;
    }
    
    /**
     * @return the $verticalAlign
     */
    public function getVerticalAlign()
    {
        return $this->verticalAlign;
    }

    /**
     * @param field_type $verticalAlign [top|middle|bottom]
     */
    public function setVerticalAlign($verticalAlign)
    {
        $verticalAlign = strtolower($verticalAlign);
        if (in_array($verticalAlign, self::$vAlignArr)) {
            $this->verticalAlign = $verticalAlign;
        }
        return $this;
    }
    
    public function setVerticalAlignTop () {
        $this->verticalAlign = "top";
        return $this;
    }

    public function setVerticalAlignMiddle () {
        $this->verticalAlign = "middle";
        return $this;
    }
    
    public function setVerticalAlignBottom () {
        $this->verticalAlign = "bottom";
        return $this;
    }
    
    /**
     * @return the $isEmbedResponsiveItem
     */
    public function getEmbedResponsive()
    {
        return $this->embedResponsive;
    }

    /**
     * @param Ambigous <boolean, array> $isEmbedResponsiveItem
     */
    public function setEmbedResponsive($embedResponsive = "16:9")
    {
        $embedRatio = explode(":", $embedResponsive);
        
        if (!empty($embedRatio) && isset($embedRatio[0]) && isset($embedRatio [1]) && is_numeric($embedRatio[1]/$embedRatio[0])) {
            $this->embedResponsive = $embedResponsive;
        }
        return $this;
    }

    
}

