<?php
namespace model\bootstrap;

use model\bootstrap\basic\Typography;

class HtmlTag implements iCaption 
{
    protected $innerText;    // string
    protected $innerHtml; // string. quick html.
    protected $cdata; // string
    protected $innerElements; // array
    protected $customClass; // array 
    protected $customStyle; // array 
    protected $attrs; // array 
    protected $html; // string

    private $tagName;    // string
    
    private static $errMsg;
    private static $unclosedTagsArr = array (
        "area",
        "base",
        "br",
        "col",
        "command",
        "embed",
        "hr",
        "img",
        "input",
        "keygen",
        "link",
        "meta",
        "param",
        "source",
        "track",
        "wbr"
    );
    
    private static $indentlevel = 0; // ing, for text indent.
    

    /**
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
    }
    
    /**
     * @desc render into a html tag.
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $html = "<" . $this->tagName;
        
        if (!empty($this->customClass)) {
            array_walk($this->customClass, "htmlspecialchars");
            $this->customClass = array_unique($this->customClass);
            $html .= " class=\"" . join(" ", $this->customClass) . "\"";
        }
        
        if (!empty($this->customStyle)) {
            array_walk($this->customStyle, "htmlspecialchars");
            $this->customStyle = array_unique($this->customStyle);
            $html .= " style=\"" . join(" ", $this->customStyle) . "\"";
        }
        
        if (!empty($this->attrs)) {
            try {
                foreach ($this->attrs as $attrName => $attrValue) {
                    $html .= " {$attrName}=\"". htmlspecialchars($attrValue) ."\"";
                }
            } catch (\Exception $e) {
                self::$errMsg = "[Error] HtmlTag Render Fail." . json_encode($this);
            }
        }
        
        // if there are innerText and innerElements both exist at same time, append text as inner element.
        if (!empty($this->innerHtml) && !empty($this->innerElements)) {
            array_unshift($this->innerElements, trim($this->innerHtml));
            $this->innerHtml = null;
        }
        if (!empty($this->innerText) && !empty($this->innerElements)) {
            array_unshift($this->innerElements, $this->innerText);
            $this->innerText = null;
        }
        
        if (!empty($this->innerText)) {
            try {
                $html .= ">";
                $html .= htmlspecialchars($this->innerText);
                $html .= "</{$this->tagName}>";
            } catch (\Exception $e) {
                self::$errMsg = "[Error] Something un-insertable: " . json_encode($this->innerText);
            }
        } else if (!empty($this->innerHtml)) {
            try {
                $html .= ">\n";
                $htmlLines = explode("\t", $this->innerHtml);
                foreach ($htmlLines as $ln) {
                    $html .= str_repeat("\t", self::$indentlevel+1) . trim($ln);
                }
                $html .= "</{$this->tagName}>";
            } catch (\Exception $e) {
                self::$errMsg = "[Error] Something un-insertable: " . json_encode($this->innerHtml);
            }
        } else if (!empty($this->cdata)) { 
            $html .= ">\n";
            $_cdataLines = explode("\n", $this->cdata);
            $html .= str_repeat("\t", self::$indentlevel+1) . join("\n" . str_repeat("\t", self::$indentlevel+1), $_cdataLines) . "\n"; 
            $html .= str_repeat("\t", self::$indentlevel) . "</{$this->tagName}>";
        } else if (!empty($this->innerElements)) {
            $html .= ">\n";
            self::$indentlevel++; 
            foreach ($this->innerElements as $ele) {
                if(empty($ele)) continue;
                if ($ele instanceof HtmlTag && method_exists($ele, "render")) {
                    $html .= str_repeat("\t", self::$indentlevel) . $ele->render() . "\n";
                } else if (is_array($ele)) {
                    self::$errMsg = "[Error] Inner element is an array." . json_encode($ele);
                    continue;
                } else {
                    $html .= str_repeat("\t", self::$indentlevel) . $ele . "\n";
                }
            }
            $html .= str_repeat("\t", --self::$indentlevel) . "</{$this->tagName}>";
        } else {
            if (!in_array ($this->tagName, self::$unclosedTagsArr)) {
                $html .= "></{$this->tagName}>";
            } else {
                $html .= "/>";
            }
        }
        
        $this->html = $html;
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
                
    }
    
    /**
     * @desc magic function to string.
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
                self::$errMsg = "[Warning] Something refused to become a string. " . $e->getMessage();
                return "";
            }
        }
    }
    
    /**
     * @desc clone all items from innerElements, body contents and items.
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
        
        
        $this->html = null; // reset render result;
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
    public function appendCustomClass($customClass = array ())
    {
        if (empty($customClass)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customClass = func_get_args();
        } else if (!is_array($customClass)) {
            $customClass = array ($customClass);
        }
        
        if(!empty($this->customClass)) $this->customClass = array_merge($this->customClass, $customClass);
        else $this->customClass = $customClass;
            
        return $this;
    }
    
    /**
     * @desc setter, merge all argvs.
     * @param multitype: $customClass
     */
    public function setCustomClass($customClass = array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customClass = func_get_args();
        } else if (!is_array($customClass)) {
            $customClass = array ($customClass);
        }
        
        $this->customClass = $customClass;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getCustomStyle()
    {
        return $this->customStyle;
    }
    
    /**
     * @param array $customStyles
     * @return \model\bootstrap\basic\Button
     */
    public function appendCustomStyle($customStyle = array ())
    {
        if (empty($customStyle)) return $this;
        
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customStyle = func_get_args();
        } else if (!is_array($customStyle)) {
            $customStyle = array ($customStyle);
        }
        
        if (!empty($this->customStyle)) $this->customStyle = array_merge($this->customStyle, $customStyle);
        else $this->customStyle = $customStyle;
        
        return $this;
    }
    
    /**
     * @desc setter
     * @param array $customStyles
     * @return \model\bootstrap\basic\Button
     */
    public function setCustomStyle($customStyle = array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $customStyle = func_get_args();
        } else if (!is_array($customStyle)) {
            $customStyle = array ($customStyle);
        }
        
        $this->customStyle = $customStyle;
        
        return $this;
    }
    
    /**
     * @desc innerElements setter.
     * @param array <multitype:, unknown> $innerElements
     */
    public function appendInnerElements($innerElements = array ())
    {
        // @todo perhaps need to get refered obj, to see how to pass by multiple arguments.
        if (empty($innerElements)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else if (!is_array($innerElements)) {
            $innerElements = array ($innerElements);
        }
        
        if ($this->innerElements) $this->innerElements = array_merge($this->innerElements, $innerElements);
        else $this->innerElements = $innerElements;
        return $this;
    }
    
    /**
     * @desc do assign, not merge.
     * @param array <multitype:, unknown> $innerElements
     */
    public function setInnerElements($innerElements = array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else if (!is_array($innerElements)) {
            $innerElements = array ($innerElements);
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
     * @desc append to attrs
     * @param Ambigous <multitype:, array> $attrs
     */
    public function appendAttrs($attrs =  array ())
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
     * @desc do assign, not merge. And you can truncate it by assign an empty array.
     * @param Ambigous <multitype:, array> $attrs
     */
    public function setAttrs($attrs =  array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $attrs = func_get_args();
        } else if (!is_array($attrs)) {
            $attrs = array ($attrs);
        }
        
        $this->attrs = $attrs;
        
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
     * @return the $errMsg
     */
    public static function getErrMsg($display = false)
    {
        if ($display == true) {
            echo "<pre>\n";
            print_r(self::$errMsg);
            echo "\n</pre>";
        } else {
            return self::$errMsg;
        }
        
    }
    
    /**
     * @return the $tagName
     */
    public function getTagName()
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
        // @todo could be better
        self::$errMsg = $errMsg;
    }

    /**
     * @desc get inner element by index. 
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
    
    /**
     * @desc set inner element by index.
     * @param unknown $index
     * @param unknown $ele
     * @return \model\bootstrap\HtmlTag
     */
    public function setElement($index, $ele) {
        $this->innerElements [$index] = $ele;
        return $this;
    }
    
    /**
     * @return the $innerHtml
     */
    public function getInnerHtml()
    {
        return $this->innerHtml;
    }

    /**
     * @param field_type $innerHtml
     */
    public function setInnerHtml($innerHtml)
    {
        $this->innerHtml = $innerHtml;
        return $this;
    }
    
    /**
     * @desc instead syntax of cloning instance. return the clone one.
     * @return \model\bootstrap\basic\Typography
     */
    public function cloneInstance(&$clone = null) {
        if (isset ($clone)) {
            $clone = clone $this;
            return $this;
        } else {
            return clone $this;
        }
    }
    
    /**
     * @desc remember this will return the outer in default.
     * @param HtmlTag $outer
     * @return \model\bootstrap\HtmlTag
     */
    public function enclose (HtmlTag $outer, $returnThis = false) {
        $outer->appendInnerElements($this);
        if ($returnThis == true) {
            return $this;
        } else {
            return $outer;
        }
        
    }
    
    
}

