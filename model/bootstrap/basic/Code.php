<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Code extends Typography 
{
    protected $lang; //string
    
    public function __construct($code = "", $vars = array (), $attr = array ())
    {
        parent::__construct("figure:highlight", $vars, $attr);
        $this->type = "code";
        $this->lang = isset($vars['lang']) ? $vars['lang'] : "php";
        $this->text = $code;
        
    }
    
    public function render($display = false) {
        $pre = new HtmlTag("pre");
        if ($this->lang == "php") {
            $pre->setInnerElements(highlight_string($this->text, true));
            
        } else {
            // @todo don't know how to deal other language at this moment.
            $codeTag = new HtmlTag("code", array ("data-lang" => $this->lang));
            $codeTag->setCustomClass("language-" . $this->lang);
            $codeTag->setInnerElements(trim($this->text));
            $pre->setInnerElements($codeTag);
        }
        
        $this->innerElements [] = $pre;
        $this->text = null;
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
            
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param field_type $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }


}



