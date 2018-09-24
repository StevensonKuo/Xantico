<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;

class Panel extends Typography  
{
    protected $heading; // string; title.
    protected $bodyContents; // string, HtmlTag
    protected $footer; // string, HtmlTag
    
//     protected $subTitle; // string
//     protected $flat; // boolean
//     protected $toolbox; //  array
    
    public static $HEADING_SIZE = 0;
    
    public function __construct($vars = array (), $attrs = array ())
    {
        parent::__construct("div:panel", $vars, $attrs);
        $this->type         = "panel";
        $this->heading      = isset ($vars ['heading']) ? $vars ['heading'] : "";
        $this->footer       = isset ($vars ['footer']) ? $vars ['footer'] : "";
        $this->colorSet     = empty($this->colorSet) ? "default" : $this->colorSet;
//         $this->subTitle     = key_exists('subTitle', $vars) ? $vars ['subTitle'] : "";
//         $this->flat         = key_exists('flat', $vars) ? $vars ['flat'] : true;
//         $this->toolbox      = key_exists('toolbox', $vars) ? $vars ['toolbox'] : array ();
        
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->colorSet)) {
            $this->setCustomClass("panel-" . $this->colorSet);    
        }
        
        $_defaultPart = array ();
        if (!empty($this->heading)) {
            $headingDiv = new HtmlTag("div");
            $headingDiv->setCustomClass("panel-heading");
            if (self::$HEADING_SIZE > 0) {
                $titleDiv = new HtmlTag("h" . self::$HEADING_SIZE);
                $titleDiv->setCustomClass("panel-title")
                ->setInnerText($this->heading);
                $headingDiv->setInnerElements($titleDiv);
            } else {
                $headingDiv->setText($this->heading);
            }
            
            $_defaultPart [] = $headingDiv;
        }
        
        if (!empty($this->bodyContents)) {
            $bodyDiv = new HtmlTag("div");
            $bodyDiv->setCustomClass("panel-body")
            ->setInnerElements($this->bodyContents);
            
            $_defaultPart [] = $bodyDiv;
        }
        
        // elements apart of heading and body will be appended follow.
        $this->innerElements = array_merge($_defaultPart, $this->innerElements);
        
        if (!empty($this->footer)) {
            $footDiv = new HtmlTag("div");
            $footDiv->setCustomClass("panel-footer")
            ->setInnerElements($this->footer);
            $this->innerElements [] = $footDiv;
        }
        
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @desc return bodyContents attr.
     * @return \model\bootstrap\the
     */
    public function getBodyContents () {
        return $this->bodyContents; 
    }
    
    /**
     * @desc body contents, different from InnerElements 
     * @param array $bodyContents
     */
    public function setBodyContents($bodyContents = array ())
    {
        if (empty($bodyContents)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array ($bodyContents);
        }
        
        if ($this->bodyContents && is_array($this->bodyContents)) $this->bodyContents = array_merge($this->bodyContents, $bodyContents);
        else $this->bodyContents = $bodyContents;
        
        return $this;
    }
    
    /**
     * @deprecated 
     * @param Ambigous <boolean, unknown> $flat
     */
    public function setFlat($flat = false)
    {
        $this->flat = $flat;
        return $this;
    }
    
    /**
     * @deprecated 
     * @return the $subTitle
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * @deprecated 
     * @param field_type $subTitle
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;
        return $this;
    }
    /**
     * @return the $heading
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param Ambigous <string, array> $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
        return $this;
    }
    
    /**
     * @return the $footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param Ambigous <string, array> $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }


    
}


