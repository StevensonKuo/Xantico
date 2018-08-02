<?php
namespace model\bootstrap\basic;

class Video
{
    protected $id;      // string
    protected $type;    // string
    protected $colorSet;// string
    protected $text;    // string
    protected $textColorSet; // string
    protected $subtitle;// string
    protected $align;   // string
    protected $caption; // string
    protected $size; // int
    protected $border; // string
    protected $innerElements = array ();
    protected $customClass = array ();
    protected $customStyle = array ();
    protected $attrs = array ();
    protected $items = array ();
    protected $textClass = array();
    protected $html; // string
    protected $jQuery; // string
    
    
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($type, $vars = array (), $attrs = array ())
    {
        $this->type     = strtolower($type);
        $this->text     = isset($vars['text']) ? $vars ['text'] : "";
        $this->colorSet = isset($vars['colorSet']) ? $vars ['colorSet'] : "default";
        $this->align    = isset($vars['align']) && $vars ['align'] ? $vars ['align'] : "right";
        $this->id       = isset($vars['id']) ? $vars ['id'] : "";
        $this->attrs    = $attrs;
        $this->items    = isset($vars['items']) ? (is_array($vars ['items']) ? $vars ['items'] : array ($vars ['items'])) : array ();
        
        return $this;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if ($display)
            echo $this->html;
            else
                return $this->html;
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
     *
     * @return the $customClass
     */
    public function getCustomClass()
    {
        return $this->customClass;
    }
    
    /**
     *
     * @param multitype: $customClass
     */
    public function setCustomClass($customClass = array ())
    {
        if (! is_array($customClass))
            $customClass = array($customClass);
            $this->customClass = array_merge($this->customClass, $customClass);
            
            return $this;
    }
    
    /**
     * 回傳自訂的 HTML Style 值。
     * @return array
     */
    public function getCustomStyle()
    {
        return $this->customStyle;
    }
    
    
    /**
     * 設定自訂的 HTML Style 值
     * @param array $customStyles
     * @return \model\bootstrap\basic\Button
     */
    public function setCustomStyle($customStyle = array ())
    {
        if (!is_array ($customStyle)) $customStyle = array ($customStyle);
        $this->customStyle = array_merge($this->customStyle, $customStyle);
        
        return $this;
    }
    
    /**
     * 設置 HTML ID.
     * @param unknown $id
     * @return \model\bootstrap\basic\Typography
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param array <multitype:, unknown> $innerElements
     */
    public function setInnerElements($innerElements = array ())
    {
        if (!is_array ($innerElements)) $innerElements = array ($innerElements);
        if ($this->innerElements) $this->innerElements = array_merge($this->innerElements, $innerElements);
        else $this->innerElements = $innerElements;
        return $this;
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
     * subtitle setter.
     * @param string $subtitle
     * @return \Bootstrap\Aceadmin\Typography
     */
    public function setSubTitle ($subtitle) {
        $this->subtitle = $subtitle;
        return $this;
    }
    
    
    /**
     * 設定 ol,ul 的子項目
     * @param array $items
     * @return \model\bootstrap\hplus\Typography
     */
    public function setItems ($items = array ()) {
        if (in_array($this->type, array ("ol", "ul"))) {
            if (!is_array($items)) $items = array ($items);
            $this->items = array_merge($this->items, $items);
        }
        
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
    
}

