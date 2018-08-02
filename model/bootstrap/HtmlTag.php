<?php
namespace model\bootstrap;

use model\bootstrap\basic\Dropdown;

class HtmlTag
{
    protected $innerText;    // string
    protected $cdata; // string
    protected $innerElements; // array
    protected $customClass; // array 
    protected $customStyle; // array 
    protected $attrs; // array 
    protected $html; // string

    private static $errMsg;
    private $tagName;    // string
    
    static private $indentlevel = 0; // ing, for text indent.
    

    /**
     * @desc 建構子
     * @param string $tagName
     * @param array $attrs
     * @return \model\bootstrap\HtmlTag
     */
    public function __construct($tagName, $attrs = array ())
    {
        $this->tagName          = strtolower($tagName);
        $this->attrs            = is_array($attrs) ? $attrs : array ();
        $this->innerElements    = array ();
        $this->customClass      = array ();
        $this->customStyle      = array ();
        
        return $this;
    }
    
    /**
     * 渲染
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        // @todo 把所有的 innerElements 都掃過一遍, 然後外部 tag 做相對應變化
        foreach ($this->innerElements as $ele) {
            // dropdown 問題
            if ($ele instanceof Dropdown && !in_array("dropdown", $this->customClass)) {
                $this->customClass [] = "dropdown";
            }
        }
        
        $html = "<" . $this->tagName;
        
        if (!empty($this->customClass)) {
            array_walk($this->customClass, "htmlspecialchars"); // 怕裡面還有陣列，會出錯
            $html .= " class=\"" . join(" ", $this->customClass) . "\"";
        }
        
        if (!empty($this->customStyle)) {
            array_walk($this->customStyle, "htmlspecialchars");
            $html .= " style=\"" . join(" ", $this->customStyle) . "\"";
        }
        
        if (!empty($this->attrs)) {
            try {
                foreach ($this->attrs as $attrName => $attrValue) {
                    $html .= " {$attrName}=\"". htmlspecialchars($attrValue) ."\"";
                }
            } catch (\Exception $e) {
                self::$errMsg = "HtmlTag Render Fail." . json_encode($this);
            }
        }
        
        if (!empty($this->innerText)) {
            try {
                $html .= ">";
                $html .= htmlspecialchars($this->innerText);
                $html .= "</{$this->tagName}>";
            } catch (\Exception $e) {
                self::$errMsg = "Something un-insertable. " . json_encode($this->innerText);
            }
        } else if (!empty($this->cdata)) { 
            $html .= ">\n";
            $html .= str_repeat("\t", self::$indentlevel++) . $this->cdata . "\n"; 
            $html .= str_repeat("\t", self::$indentlevel--) . "</{$this->tagName}>";
        } else if (!empty($this->innerElements)) {
            $html .= ">\n";
            self::$indentlevel++; 
            foreach ($this->innerElements as $ele) {
                if(empty($ele)) continue;
                if ($ele instanceof HtmlTag && method_exists($ele, "render")) {
                    $html .= str_repeat("\t", self::$indentlevel) . $ele->render() . "\n";
                } else if (is_array($ele)) {
                    self::$errMsg = "inner element is an array." . json_encode($ele);
                    continue;
                } else {
                    $html .= str_repeat("\t", self::$indentlevel) . $ele . "\n";
                }
            }
            $html .= str_repeat("\t", --self::$indentlevel) . "</{$this->tagName}>";
        } else {
            $html .= "/>";
        }
        
        $this->html = $html;
        
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
                self::$errMsg = "Something refused to become a string. " . $e->getMessage();
                return "";
            }
        }
    }
    
    /**
     * @desc clone 時把內部的元素和項目也都 copy 一份
     */
    public function __clone() {
        if (!empty($this->innerElements)) {
            $_elements = array ();
            foreach ($this->innerElements as &$el) {
                if (is_object($el)) {
                    $_elements [] = clone $el;
                } else {
                    $_elements [] = $el;
                }
            }
            $this->innerElements = $_elements;
        }
        
        if(!empty($this->items)) {
            $_items = array ();
            foreach ($this->items as &$it) {
                if (is_object($it)) {
                    $_items [] = clone $it;
                } else {
                    $_items [] = $it;
                }
            }
            $this->items = $_items;
        }
    }
        
    /**
     * @desc innerText getter.
     * @return the $text
     */
    public function getInnerText()
    {
        return $this->innerText;
    }
    
    /**
     * @desc alternative innerText getter.
     * @return unknown
     */
    public function getText()
    {
        return $this->innerText;
    }
    
    /**
     * @desc customClass getter.
     * @return the $customClass
     */
    public function getCustomClass()
    {
        return $this->customClass;
    }
    
    /**
     * @desc customClass setter
     * @param multitype: $customClass
     */
    public function setCustomClass($customClass = array ())
    {
        if (empty($customClass)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customClass = func_get_args();
        } else {
            if (!is_array($customClass)) $customClass = array ($customClass);
        }
        
        if(!empty($this->customClass)) $this->customClass = array_merge($this->customClass, $customClass);
        else $this->customClass = $customClass;
            
        return $this;
    }
    
    /**
     * @desc 不 merge 版本
     * @param multitype: $customClass
     */
    public function assignCustomClass($customClass = array ())
    {
        if (empty($customClass)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customClass = func_get_args();
        } else {
            if (!is_array($customClass)) $customClass = array ($customClass);
        }
        
        $this->customClass = $customClass;
        
        return $this;
    }
    
    public function truncateClass () {
        $this->customClass = array ();
        return $this;
    }
    
    public function truncateStyle () {
        $this->customStyle = array ();
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
        if (empty($customStyle)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customStyle = func_get_args();
        } else {
            if (!is_array($customStyle)) $customStyle = array ($customStyle);
        }
        
        if (!empty($this->customStyle)) $this->customStyle = array_merge($this->customStyle, $customStyle);
        else $this->customStyle = $customStyle;
        
        return $this;
    }
    
    /**
     * @desc 不 merge 版本
     * @param array $customStyles
     * @return \model\bootstrap\basic\Button
     */
    public function assignCustomStyle($customStyle = array ())
    {
        if (empty($customStyle)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customStyle = func_get_args();
        } else {
            if (!is_array($customStyle)) $customStyle = array ($customStyle);
        }
        
        $this->customStyle = $customStyle;
        
        return $this;
    }
    
    /**
     * @desc innerElements setter.
     * @param array <multitype:, unknown> $innerElements
     */
    public function setInnerElements($innerElements = array ())
    {
        if (empty($innerElements)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else {
            if (!is_array($innerElements)) $innerElements = array ($innerElements);
        }
        
        if ($this->innerElements) $this->innerElements = array_merge($this->innerElements, $innerElements);
        else $this->innerElements = $innerElements;
        return $this;
    }
    
    /**
     * @desc 不 merge 的版本
     * @param array <multitype:, unknown> $innerElements
     */
    public function assignInnerElements($innerElements = array ())
    {
        if (empty($innerElements)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else {
            if (!is_array($innerElements)) $innerElements = array ($innerElements);
        }
        
        $this->innerElements = $innerElements;
        return $this;
    }
    
    /**
     * innerText alternative setter.
     * @param string $text
     * @return \Bootstrap\Aceadmin\Typography
     */
    public function setText ($text) {
        $this->innerText = $text;
        return $this;
    }
    
    /**
     * innerText setter.
     * @param string $text
     * @return \Bootstrap\Aceadmin\Typography
     */
    public function setInnerText ($text) {
        $this->innerText = $text;
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
        if (empty($attrs)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $attrs = func_get_args();
        } else {
            if (!is_array($attrs)) $attrs = array ($attrs);
        }
        
        if ($this->attrs && is_array($this->attrs)) $this->attrs = array_merge($this->attrs, $attrs);
        else $this->attrs = $attrs;
        
        return $this;
    }

    /**
     * @desc 不 merge 版本
     * @param Ambigous <multitype:, array> $attrs
     */
    public function assignAttrs($attrs =  array ())
    {
        if (empty($attrs)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $attrs = func_get_args();
        } else {
            if (!is_array($attrs)) $attrs = array ($attrs);
        }
        
        $this->attrs = $attrs;
        
        return $this;
    }
    
    public function truncateAttrs () {
        $this->attrs = array ();
        return $this;
    }

    /**
     * @return the $cdata
     */
    public function getCdata()
    {
        return $this->cdata;
    }

    /**
     * @param field_type $cdata
     */
    public function setCdata($cdata = "")
    {
        $this->cdata = $cdata;
        return $this;
    }
    /**
     * @return the $innerElements
     */
    public function getInnerElements()
    {
        return $this->innerElements;
    }
    
    /**
     * @desc 清空現有元素
     * @return \model\bootstrap\HtmlTag
     */
    public function truncateElements () {
        $this->innerElements = array ();
        return $this;
    }
    
    /**
     * @return the $errMsg
     */
    public static function getErrMsg()
    {
        return self::$errMsg;
    }
    
    /**
     * @return the $tagName
     */
    protected function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     */
    protected function setTagName($tagName)
    {
        $this->tagName = $tagName;
        return $this;
    }
    
    /**
     * @param string $errMsg
     */
    protected static function setErrMsg($errMsg)
    {
        // @todo 目前設了 error message 好像都還是找不到
        self::$errMsg = $errMsg;
    }

    /**
     * @desc 透過 index 取得單個 element. 
     * @param unknown $index
     * @return unknown|NULL
     */
    public function getElement($index) {
        if (isset ($this->innerElements [$index])) {
            return $this->innerElements [$index];
        } else {
            return null;
        }
    }
    

}

