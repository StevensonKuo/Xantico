<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;

class Media extends Typography
{
 
    protected $mediaObject; // String, Array, HtmlTag
    protected $bodyContents; // HtmlTag
    
    private static $mediaTypeArr = array ("media", "media-list");
    

    /**
     * @param array $vars
     * @param array $attr
     */
    public function __construct($type = "", $vars = array (), $attr = array())
    {
        if (empty($type) || !in_array($type, self::$mediaTypeArr)) $type = "media";
        parent::__construct("div:$type", $vars, $attr);
        
        $this->mediaObject    = isset ($vars ['mediaObject']) ? $vars ['mediaObject'] : null;
        $this->bodyContents   = isset ($vars ['bodyContents']) ? $vars ['bodyContents'] : null;
    }
    
    /**
     * @desc left addon + original inner elements + right addon = new inner elements.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        if (!empty($this->mediaObject)) {
            $divMediaLeft = new HtmlTag("div");
            $divMediaLeft->setCustomClass("media-left");
            $divMediaRight = new HtmlTag("div");
            $divMediaRight->setCustomClass("media-right");
            if (is_array($this->mediaObject)) {
                
                foreach ($this->mediaObject as $medium) {
                    if ($medium instanceof HtmlTag && !in_array("media-object", $medium->getCustomClass())) {
                        $medium->setCustomClass("media-object");
                    }
                    $_align = isset($medium) && method_exists($medium, "getAlign") ? $medium->getAlign() : "left";
                    $_valign = isset($medium) && method_exists($medium, "getVerticalAlign") ? "media-" . $medium->getVerticalAlign() : null;
                    if ($_align == "left") {
                        if ($_valign !== null && !in_array($_valign, $divMediaLeft->getCustomClass())) {
                            $divMediaLeft->setCustomClass($_valign);
                        }
                        $divMediaLeft->setInnerElements($medium);
                    } else { // right
                        if ($_valign !== null && !in_array($_valign, $divMediaRight->getCustomClass())) {
                            $divMediaRight->setCustomClass($_valign);
                        }
                        $divMediaRight->setInnerElements($medium);
                    }
                }
            } else {
                $_align = isset($this->mediaObject) && method_exists($this->mediaObject, "getAlign") && !empty($this->mediaObject->getAlign()) ? $this->mediaObject->getAlign() : "left";
                $_valign = isset($this->mediaObject) && method_exists($this->mediaObject, "getVerticalAlign") ? "media-" . $this->mediaObject->getVerticalAlign() : null;
                if ($this->mediaObject instanceof HtmlTag && !in_array("media-object", $this->mediaObject->getCustomClass())) {
                    $this->mediaObject->setCustomClass("media-object");
                }
                if ($_align == "left") {
                    if ($_valign !== null && !in_array($_valign, $divMediaLeft->getCustomClass())) {
                        $divMediaLeft->setCustomClass($_valign);
                    }
                    $divMediaLeft->setInnerElements($this->mediaObject);
                } else { // right
                    if ($_valign !== null && !in_array($_valign, $divMediaRight->getCustomClass())) {
                        $divMediaRight->setCustomClass($_valign);
                    }
                    $divMediaRight->setInnerElements($this->mediaObject);
                }
            }
            
            if (!empty($divMediaLeft->getInnerElements())) $this->innerElements [] = $divMediaLeft;
            // right part is insert after body contenz.
        }
        
        if (!empty($this->bodyContents)) {
            $divBody = new Typography("div:media-body");
            foreach ($this->bodyContents as $content) {
//                 if ($content instanceof HtmlTag && !in_array("media-object", $content->getCustomClass())) {
//                     $content->setCustomClass("media-object");
//                 }
                if ($content instanceof HtmlTag && method_exists($content, "getTagName") 
                    && preg_match("/^h[1-6]{1}$/", $content->getTagName()) && !in_array("media-heading", $content->getCustomClass())) {
                        $content->setCustomClass("media-heading");
                }
                $divBody->setInnerElements($content);
            }
            $this->innerElements [] = $divBody;
        }
        
        if (isset ($divMediaRight) && !empty($divMediaRight->getInnerElements())) $this->innerElements [] = $divMediaRight;
        
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $mediaObject
     */
    public function getMediaObject()
    {
        return $this->mediaObject;
    }

    /**
     * @param field_type $mediaObject
     */
    public function setMediaObject($mediaObject)
    {
        $this->mediaObject = $mediaObject;
        return $this;
    }
    
    /**
     * @return the $bodyContents
     */
    public function getBodyContents()
    {
        return $this->bodyContents;
    }
    
    /**
     * @desc for getting single body element
     * @param unknown $index
     * @return unknown|NULL
     */
    public function getBodyContent($index)
    {
        if (isset($this->bodyContents [$index])) {
            return $this->bodyContents [$index];
        } else {
            return null;
        }
        
    }

    /**
     * @param Ambigous <multitype:, field_type> $bodyContents
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
     * @desc only Media class has this funciton public for Media List using.
     * @param string $tagName
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
        return $this;
    }
    
}
