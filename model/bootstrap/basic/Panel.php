<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;

class Panel extends Typography  
{
    protected $heading; // string; title.
    protected $subTitle; // string
    protected $flat; // boolean
    protected $toolbox; //  array
    
    public static $headingSize = 3;
    
    public function __construct($vars = array (), $attrs = array ())
    {
        parent::__construct("div:panel", $vars, $attrs);
        $this->type         = "panel";
        $this->heading      = key_exists('heading', $vars) ? $vars ['heading'] : "";
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
        
        $headingDiv = new HtmlTag("div");
        $headingDiv->setCustomClass("panel-heading");
        $titleDiv = new HtmlTag("h" . self::$headingSize);
        $titleDiv->setCustomClass("panel-title")
        ->setInnerText($this->heading);
        $headingDiv->setInnerElements($titleDiv);
        
        $bodyDiv = new HtmlTag("div");
        $bodyDiv->setCustomClass("panel-body")
        ->setInnerElements($this->innerElements);
        
        $this->innerElements = array ($headingDiv, $bodyDiv);
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @ body contents 其實就是 innerElements
     * @return \model\bootstrap\the
     */
    public function getBodyContents () {
        return $this->getInnerElements();
    }
    
    /**
     * @param array $bodyContents
     */
    public function setBodyContents($bodyContents = array())
    {
        $this->setInnerElements($bodyContents);   
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

    
}


