<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;

class Typography extends \model\bootstrap\HtmlTag 
{
    protected $type;    // string
    protected $mode; // for one more type/mode to switch what you want.
    protected $id;      // string
    protected $context;// string
    protected $textContext; // string
    protected $caption; // string; !important different from text/innerText
    protected $title;// string
    protected $align;   // string
    protected $verticalAlign; // string
    protected $size; // int
    protected $border; // int
    protected $items; // array 
    protected $textClass; // array 
    protected $textAlign; // for text-align classes.
    protected $textTransform; // string
    protected $bgContext; // string
    protected $grid; // int or array(), Bootstrap Grids System
    protected $gridOffset; // int
    protected $embedResponsive; // ratio, 16by9 or 4by3
    protected $isLead; // boolean
    protected $isListUnstyled; // boolean
    protected $isListInline; // boolean
    protected $clearFix; // boolean
    protected $jQuery; // string
    
    protected static $alignArr          = array("right", "left", "center", "");
    protected static $vAlignArr         = array("top", "middle", "bottom", "");
    protected static $textAlignArr      = array ("left", "center", "right", "justify", "nowrap", "");
    protected static $textTransformArr  = array ("uppercase", "lowercase", "capitalize", "");
    protected static $contextArr        = array ("success", "default", "primary", "danger", "warning", "info", "");
    protected static $textContextArr    = array ("success", "muted", "primary", "danger", "warning", "info", "");
    protected static $embedTagsArr      = array("iframe", "embed", "video", "object");
    
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
        $divX = explode(":", $type); // div:row, div:badge, :page-header etc... 
        $tagName = isset($divX [0]) ? $divX [0] : (isset($divX [1]) ? "div" : $type);
        
        parent::__construct($tagName, $attrs);
        
        if (isset($divX [1])) {
            $type = $divX [1];
            $this->customClass [] = $type;
        }
        
        // other attributes initialize.
        ++self::$instanceCounter;
        if (self::$AUTO_ID == true && !isset($vars['id'])) {
            $this->id = self::generateTagId($this);
        } else if (isset($vars['id']) && !empty($vars['id'])) {
            $this->id = $vars ['id'];
        }
        
        $this->type         = strtolower($type);
        // HtmlTag attrs.
        $this->innerText        = isset($vars['text']) ? $vars['text'] : "";
        $this->innerText        = isset($vars['innerText']) ? $vars['innerText'] : $this->innerText;
        $this->innerHtml        = isset($vars['innerHtml']) ? $vars['innerHtml'] : "";
        $this->cdata            = isset($vars['cdata']) ? $vars['cdata'] : "";
        $this->innerElements    = isset($vars['innerElements']) ? $vars['innerElements'] : array();
        // Typography attrs.
        $this->context          = isset($vars['context']) ? $vars['context'] : "";
        $this->textContext      = isset($vars['textContext']) ? $vars ['textContext'] : "";
        $this->caption          = isset($vars ['caption']) ? $vars ['caption'] : "";
        $this->title            = isset($vars ['title']) ? $vars ['title'] : "";
        $this->align            = isset($vars ['align']) ? $vars ['align'] : "";
        $this->size             = isset($vars ['size']) ? $vars ['size'] : 0;
        $this->border           = isset($vars ['border']) ? $vars ['border'] : 0;
        $this->items            = isset($vars ['items']) ? (is_array($vars ['items']) ? $vars ['items'] : array ($vars ['items'])) : array ();
        $this->textClass        = isset($vars ['textClass']) ? (is_array($vars ['textClass']) ? $vars ['textClass'] : array ($vars ['textClass'])) : array ();
        $this->grid             = isset($vars ['grid']) ? $vars ['grid'] : null;
        $this->mode             = isset($vars ['mode']) ? $vars ['mode'] : null;
        $this->embedResponsive  = isset ($vars ['embedResponsive']) ? $vars ['embedResponsive'] : "";
        $this->isListUnstyled   = isset($vars ['isListUnstyled']) ? $vars ['isListUnstyled'] : false;
        $this->isListInline     = isset($vars ['isListInline']) ? $vars ['isListInline'] : false;
        $this->clearFix         = isset($vars ['clearFix']) ? $vars ['clearFix'] : false;
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->items)) { // ol/ul/dl
            if (in_array ($this->getTagName(), array ("ul", "ol"))) {
                foreach ($this->items as $item) {
                    if ($item instanceof HtmlTag && $item->getTagName() == "li") {
                        // if the element are tag li already, it doesn't modify it.
                        $this->innerElements [] = $item;
                    } else {
                        $_li = new HtmlTag("li");
                        $_li->appendInnerElements($item);
                        $this->innerElements [] = $_li;
                        unset ($_li);
                    }
                }
            } else if ($this->getTagName() == "dl") {
                foreach ($this->items as $item) {
                    if ($item instanceof HtmlTag && in_array($item->getTagName(), array("dd", "dt"))) {
                        // if the element are tag li already, it doesn't modify it.
                        $this->innerElements [] = $item;
                    } else {
                        $_dt = new HtmlTag("dt");
                        $_dt->appendInnerElements(isset($item ['dt']) ? $item ['dt'] : "");
                        $this->innerElements [] = $_dt;
                        $_dd = new HtmlTag("dd");
                        $_dd->appendInnerElements(isset($item ['dd']) ? $item ['dd'] : $item);
                        $this->innerElements [] = $_dd;
                        unset ($_dt);
                        unset ($_dd);
                    }
                }
            }
        }
        
        if (!empty($this->id)) $this->appendAttrs(array ("id" => $this->id));
        
        if (!empty($this->grid)) { // handle grids system.
            if (is_array($this->grid)) {
                foreach ($this->grid as $grid) {
                    $this->customClass [] = $grid;
                }
                if (is_array($this->gridOffset)) {
                    foreach ($this->gridOffset as $offset) {
                        $this->customClass [] = $offset;
                    }
                }
            } else {
                $this->customClass [] = "col-md-" . $this->grid;
                if (is_numeric($this->gridOffset)) {
                    $this->customClass [] = "col-md-offset-" . $this->gridOffset;
                }
            }
        }
        
        if (!empty($this->embedResponsive)) {
            $embedRatio = explode(":", $this->embedResponsive);
            $this->customClass [] = "embed-responsive";
            $this->customClass [] = "embed-responsive-" . join("by", $embedRatio);    
        }
        
        if (!empty($this->textContext)) {
            $this->customClass [] = "text-" . $this->textContext;
        }
        
        if (!empty($this->textAlign)) {
            $this->customClass [] = "text-" . $this->textAlign;
        }
        
        if (!empty($this->textTransform)) {
            $this->customClass [] = "text-" . $this->textTransform;
        }
        
        if (!empty($this->bgContext)) {
            $this->customClass [] = "bg-" . $this->bgContext;
        }
        
        if ($this->isLead == true) {
            $this->customClass [] = "lead";
        }
        
        if ($this->isListUnstyled == true) {
            $this->customClass [] = "list-unstyled";
        }
        
        if ($this->isListInline == true) {
            $this->customClass [] = "list-inline";
        }
        
        if ($this->clearFix == true) {
            $this->customClass [] = "clearfix";
        }
        
        // @todo scan all innerElements, if you want to do any operation to those childs, add it here.
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                // dropdown issue, if this dropdown is not a button-group and it's type not in class yet.
                if ($ele instanceof HtmlTag) {
                    // for responsive table
                    if ($ele instanceof Table && $ele->getIsResponsive() == true 
                        && !in_array("table-responsive", $this->customClass)) {
                            $this->customClass [] = "table-responsive";
                    }
                    
                    // for inline dropdown elements
                    if (method_exists($ele, "getType") && method_exists($ele, "getMode")) {
                        $_type = $ele->getType();
                        $_mode = $ele->getMode ();
                        if (($_type == "dropdown" || $_type == "dropup") && $_mode != "button" && !in_array($_type, $this->customClass)) {
                            $this->customClass [] = $_type;
                        }
                    }
                    
                    // for embed responsive
                    if (!empty($this->embedResponsive) 
                        && !in_array("embed-responsive-item", $ele->getCustomClass())
                        && in_array($ele->getTagName(), self::$embedTagsArr)) {
                            $ele->appendCustomClass("embed-responsive-item");
                    }
                }
                
                // reset the order left to right.
                if ($ele instanceof Typography && !empty($ele->getAlign())) {
                    $ele->appendCustomClass("pull-" . $ele->getAlign());
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
        if (!empty($this->html)) {
            return $this->html;
        } else {
            try {
                return $this->render();
            } catch (\Exception $e) {
                $this->setErrMsg("[Error] Some errors occur during rendering: " . $this->getTagName() . ":" . $this->type);
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
        } else if (!is_array($items)) {
            $items = array ($items);
        }
        
        $this->items = $items;
        return $this;
    }
     
    /**
     * @desc setter, merge all argvs.
     * @param array $items
     * @return \model\bootstrap\hplus\Typography
     */
    public function appendItems ($items) {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $items = func_get_args();
        } else if (!is_array($items)) {
            $items = array ($items);
        }
        
        if ($this->items) $this->items = array_merge($this->items, $items);
        else $this->items = $items;
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
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return the $context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return the $textContext
     */
    public function getTextContext()
    {
        return $this->textContext;
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
    protected function setType($type)
    {
        $this->type = strtolower($type);
        return $this;
    }

    /**
     * @desc set up scene color.
     * @param Ambigous <string, array> $context
     */
    public function setContext($context)
    {
        $context = strtolower($context);
        if (in_array($context, self::$contextArr)) {
            $this->context = strtolower($context);
        }
        
        return $this;
    }
    
    // contextual class setter start.
    public function setContextSuccess () {
        $this->context = "success";
        return $this;
    }
    
    public function setContextInfo () {
        $this->context = "info";
        return $this;
    }
    
    public function setContextWarning () {
        $this->context = "warning";
        return $this;
    }
    
    public function setContextDanger () {
        $this->context = "danger";
        return $this;
    }
    
    public function setContextPrimary () {
        $this->context = "primary";
        return $this;
    }
    
    public function setContextDefault () {
        $this->context = "default";
        return $this;
    }
    // contextual class setter end.
    
    /**
     * @param Ambigous <string, array> $textContext
     */
    public function setTextContext($textContext)
    {
        $textContext = strtolower($textContext);
        if (in_array($textContext, self::$textContextArr)) {
            $this->textContext = $textContext;
        }
        
        return $this;
    }
    
    public function setTextContextMuted () {
        $this->textContext = "muted";
        return $this;
    }

    public function setTextContextSuccess () {
        $this->textContext = "success";
        return $this;
    }
    
    public function setTextContextPrimary () {
        $this->textContext = "primary";
        return $this;
    }

    public function setTextContextInfo () {
        $this->textContext = "info";
        return $this;
    }

    public function setTextContextWarning () {
        $this->textContext = "warning";
        return $this;
    }

    public function setTextContextDanger () {
        $this->textContext = "danger";
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
     * @desc three sizes [xs|sm|lg]
     * @param string $size
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
                //                 $this->size = "miner";
                $this->size = ""; // preserved.
                break;
            case 2:
                $this->size = "xs";
                break;
            case 3:
                $this->size = "sm";
                break;
            case 4:
                $this->size = "";
                break;
            case 5:
                $this->size = "lg";
                break;
            default:
                $this->size = $size;
                
        }
        
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
     * @desc generate an id for tag (based on counter)
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
    
    /**
     * @return the $textAlign
     */
    public function getTextAlign()
    {
        return $this->textAlign;
    }

    /**
     * @param field_type $textAlign
     */
    public function setTextAlign($textAlign)
    {
        $textAlign = strtolower($textAlign);
        if (in_array($textAlign, self::$textAlignArr)) {
            $this->textAlign = $textAlign;
        }
        
        return $this;
    }
    
    public function setTextAlignLeft () {
        $this->textAlign = "left";
        return $this;
    }
    
    public function setTextAlignCenter () {
        $this->textAlign = "center";
        return $this;
    }
    
    public function setTextAlignRight () {
        $this->textAlign = "right";
        return $this;
    }

    public function setTextAlignJustify () {
        $this->textAlign = "justify";
        return $this;
    }

    public function setTextAlignNowrap () {
        $this->textAlign = "nowrap";
        return $this;
    }
/**
     * @return the $isLead
     */
    public function getIsLead()
    {
        return $this->isLead;
    }

    /**
     * @param field_type $isLead
     */
    public function setIsLead($isLead = true)
    {
        $this->isLead = $isLead;
        return $this;
    }
    
    /**
     * @return the $textTransform
     */
    public function getTextTransform()
    {
        return $this->textTransform;
    }

    /**
     * @param field_type $textTransform
     */
    public function setTextTransform($textTransform)
    {
        $textTransform = strtolower($textTransform);
        if (in_array($textTransform, self::$textTransformArr)) {
            $this->textTransform = $textTransform;
        }
        
        return $this;
    }
    
    public function setTextUpperCase () {
        $this->textTransform = "uppercase";
        return $this;
    }

    public function setTextLowerCase () {
        $this->textTransform = "uppercase";
        return $this;
    }
    
    public function setTextCapitalize () {
        $this->textTransform = "capitalize";
        return $this;
    }
    
    /**
     * @return the $isListUnstyled
     */
    public function getIsListUnstyled()
    {
        return $this->isListUnstyled;
    }

    /**
     * @return the $isListInline
     */
    public function getIsListInline()
    {
        return $this->isListInline;
    }

    /**
     * @param field_type $isListUnstyled
     */
    public function setIsListUnstyled($isListUnstyled = true)
    {
        $this->isListUnstyled = $isListUnstyled;
        return $this;
    }

    /**
     * @param field_type $isListInline
     */
    public function setIsListInline($isListInline = true)
    {
        $this->isListInline = $isListInline;
        return $this;
    }
    
    /**
     * @return the $clearFix
     */
    public function getClearFix()
    {
        return $this->clearFix;
    }

    /**
     * @param field_type $clearFix
     */
    public function setClearFix($clearFix = true)
    {
        $this->clearFix = $clearFix;
        return $this;
    }
    
    /**
     * @return the $bgContext
     */
    public function getBgContext()
    {
        return $this->bgContext;
    }

    /**
     * @param field_type $bgContext
     */
    public function setBgContext($bgContext)
    {
        $bgContext = strtolower($bgContext);
        if (in_array($bgContext, self::$contextArr)) {
            $this->bgContext = $bgContext;
        }
        
        return $this;
    }

    public function setBgContextPrimary () {
        $this->bgContext = "primary";
        return $this;
    }

    public function setBgContextSuccess () {
        $this->bgContext = "success";
        return $this;
    }
    
    public function setBgContextInfo () {
        $this->bgContext = "info";
        return $this;
    }
    
    public function setBgContextWarning () {
        $this->bgContext = "warning";
        return $this;
    }
    
    public function setBgContextDanger () {
        $this->bgContext = "danger";
        return $this;
    }
    
}

