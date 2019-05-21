<?php
namespace Xantico\Bootstrap;

use Xantico\Bootstrap\Basic\Typography;

class HtmlTag implements CaptionInterface
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
    
    private static $indentLevel = 0; // ing, for text indent.
    

    /**
     * @param string $tagName
     * @param array $attrs
     * @return \model\Xantico\HtmlTag
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
                    $html .= str_repeat("\t", self::$indentLevel+1) . trim($ln);
                }
                $html .= "</{$this->tagName}>";
            } catch (\Exception $e) {
                self::$errMsg = "[Error] Something un-insertable: " . json_encode($this->innerHtml);
            }
        } else if (!empty($this->cdata)) { 
            $html .= ">\n";
            $_cdataLines = explode("\n", $this->cdata);
            $html .= str_repeat("\t", self::$indentLevel+1) . join("\n" . str_repeat("\t", self::$indentLevel+1), $_cdataLines) . "\n";
            $html .= str_repeat("\t", self::$indentLevel) . "</{$this->tagName}>";
        } else if (!empty($this->innerElements)) {
            $html .= ">\n";
            self::$indentLevel++;
            foreach ($this->innerElements as $ele) {
                if(empty($ele)) continue;
                if ($ele instanceof HtmlTag) {
                    $html .= str_repeat("\t", self::$indentLevel) . $ele->render() . "\n";
                } else if (is_array($ele)) {
                    self::$errMsg = "[Error] Inner element is an array." . json_encode($ele);
                    continue;
                } else {
                    $html .= str_repeat("\t", self::$indentLevel) . $ele . "\n";
                }
            }
            $html .= str_repeat("\t", --self::$indentLevel) . "</{$this->tagName}>";
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
     * magic function to string.
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
     * Clone all items from innerElements, body contents and items.
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
     * innerText getter.
     * @return string
     */
    public function getInnerText()
    {
        return $this->innerText;
    }
    
    /**
     * @desc alternative innerText getter.
     * @return string
     */
    public function getText()
    {
        return $this->innerText;
    }

    /**
     * customClass getter.
     * @return array
     */
    public function getCustomClass()
    {
        return $this->customClass;
    }

    /**
     * customClass setter
     * @param array $customClass
     * @return $this
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
     * setter, merge all argvs.
     * @param array $customClass
     * @return $this
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
     * @return \model\Xantico\basic\Button
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
     * html style setter
     * @param array $customStyles
     * @return \model\Xantico\basic\Button
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
     * innerElements setter.
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
     * do assign, not merge.
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
     * Alias of setInnerText.
     * @param string $text
     * @return $this
     */
    public function setText ($text) {
        $this->innerText = $text;
        return $this;
    }
    
    /**
     * innerText setter.
     * @param string $text
     * @return Typography
     */
    public function setInnerText ($text) {
        $this->innerText = $text;
        return $this;
    }
    
    /**
     * @return array $attrs
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
     * do assign, not merge. And you can truncate it by assign an empty array.
     * @param array $attrs
     * @return $this
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
     * @return string $cdata
     */
    public function getCdata()
    {
        return $this->cdata;
    }

    /**
     * @param string $cdata
     * @return $this
     */
    public function setCdata($cdata = "")
    {
        $this->cdata = $cdata;
        return $this;
    }
    /**
     * @return array $innerElements
     */
    public function getInnerElements()
    {
        return $this->innerElements;
    }
    
    /**
     * @return string $errMsg
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
     * @return string $tagName
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
     * @param $index
     * @return mixed|null
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
     * @return \model\Xantico\HtmlTag
     */
    public function setElement($index, $ele) {
        $this->innerElements [$index] = $ele;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getInnerHtml()
    {
        return $this->innerHtml;
    }

    /**
     * @param string $innerHtml
     */
    public function setInnerHtml($innerHtml)
    {
        $this->innerHtml = $innerHtml;
        return $this;
    }

    /**
     * instead syntax of cloning instance. return the clone one.
     * @param null $clone
     * @return $this|HtmlTag
     */
    public function cloneInstance(&$clone = null) {
        if (isset ($clone) && $clone instanceof self) {
            $clone = clone $this;
            return $this;
        } else {
            return clone $this;
        }
    }

    /**
     * Like a reverse method of setInnerElements, remember this will return the outer in default.
     * @param HtmlTag $outer
     * @param bool $returnThis
     * @return $this|HtmlTag
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

