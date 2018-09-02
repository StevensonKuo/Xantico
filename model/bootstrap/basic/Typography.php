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
    protected $size; // int
    protected $border; // int
    protected $items; // array 
    protected $textClass; // array 
    protected $jQuery; // string
    protected $grids; // int or array(), Bootstrap Grids System
    protected $mode; // for one more type/mode to switch what you want.
    
    private static $instanceCounter = 0; // int
    
    public static $autoId = false;
    

    /**
     * 建構子
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
        if (self::$autoId == true && !isset($vars['id'])) {
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
        $this->items        = isset($vars['items']) ? (is_array($vars ['items']) ? $vars ['items'] : array ($vars ['items'])) : array ();
        $this->textClass    = isset($vars['textClass']) ? (is_array($vars ['textClass']) ? $vars ['textClass'] : array ($vars ['textClass'])) : array ();
        $this->grids        = isset($vars ['grids']) ? $vars ['grids'] : null;
        $this->mode         = isset($vars ['mode']) ? $vars ['mode'] : null;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->items)) { // ol/ul/select
            if (in_array ($this->type, array ("ul", "ol", "select", "navi", "dropdown"))) {
                foreach ($this->items as $item) {
                    if ($item instanceof HtmlTag && $item->getTagName() == "li") {
                        // 若已經是 li 就丟進去
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
        
        if (!empty($this->grids)) { // handle grids system.
            if (is_array($this->grids)) {
                try {
                    if (!empty($this->grids)) {
                        foreach ($this->grids as $grid) {
                            $this->setCustomClass("col-" . $grid [0] . "-" . $grid [1]);
                        }
                    } else {
                        $this->setCustomClass("col");
                    }
                } catch (\Exception $e) {
                    $this->errMsg = "Tag [{$this->tagName}] occurs error in operating grids: " . $e->getMessage();
                }
            } else {
                $this->setCustomClass("col-md-" . $this->grids);
            }
        }
        
        parent::render();
        
        $jQuery = "";
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as $ele) {
                if (empty($ele)) continue; // pass 空物件.
//                 if ($ele instanceof Typography) { // 還沒改完很多還不是 HtmlTag 延伸物件
                if (true) {
                    if (method_exists($ele, "getJQuery")) $jQuery .= $ele->getJQuery () . "\n";
                }
            }
        }
        
        $this->jQuery .= $jQuery;
        
        if ($display) {
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
     * 設置 HTML ID. 若不代值會自動產生
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
     * 回傳 HTML ID 值
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
     * @desc 設定 ol,ul,select, navi... 
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

    /**
     * @param Ambigous <string, array> $textColorSet
     */
    public function setTextColorSet($textColorSet)
    {
        $this->textColorSet = $textColorSet;
        return $this;
    }

    /**
     * @param Ambigous <string, array> $align
     */
    public function setAlign($align)
    {
        $this->align = $align;
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
     * @return the $grids
     */
    public function getGrids()
    {
        return $this->grids;
    }

    /**
     * @param Ambigous <NULL, array> $grids
     */
    public function setGrids($grids)
    {
        $this->grids = $grids;
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
     * @desc 透過 index 取得 item 
     * @param unknown $index
     * @return array|NULL
     */
    public function getItem($index) {
        if (isset ($this->items [$index])) {
            return $this->items [$index]; 
        } else {
            return null;
        }
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

    
}

