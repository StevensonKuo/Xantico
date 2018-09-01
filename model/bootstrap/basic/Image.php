<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Image extends Typography
{
    protected $width;
    protected $height;
    protected $alt;
    protected $source;
    //     protected $theme;
    
    const BOOTSTRAP_THUMBNAIL_DEFAULT_WIDTH = 200;
    const BOOTSTRAP_THUMBNAIL_DEFAULT_HEIGHT = 200;
    
    /**
     * 建構子
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\bootstrap\basic\Typography
     */
    public function __construct($type = "", $vars = array (), $attrs = array ())
    {
        
        parent::__construct("img", $vars, $attrs);
        
        $this->type     = strtolower($type);
        $this->width    = isset ($vars ['width']) ? $vars ['width'] : null;
        $this->height   = isset ($vars ['height']) ? $vars ['height'] : null;
        $this->alt      = isset ($vars ['alt']) ? $vars ['alt'] : "";
        $this->source   = isset ($vars ['src']) ? $vars ['src'] : "";
        $this->source   = isset ($vars ['source']) ? $vars ['source'] : $this->source;
        //         $this->theme    = isset ($vars ['theme']) ? $vars ['theme'] : "";
        
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        
        if (!empty($this->width)) {
            $this->setAttrs(array("width" => $this->width));
        }
        if (!empty($this->height)) {
            $this->setAttrs(array("height" => $this->height));
        }
        if (!empty($this->alt)) {
            $this->setAttrs(array("alt" => $this->alt));
        }
        
        switch ($this->type) {
            case "thumbnail":
            case "thumbnails":
                if (empty($this->width)) $this->width = self::BOOTSTRAP_THUMBNAIL_DEFAULT_WIDTH;
                if (empty($this->height)) $this->height = self::BOOTSTRAP_THUMBNAIL_DEFAULT_HEIGHT;
                $this->setCustomClass("img-thumbnail");
                $this->source = $this->source . "/" . $this->width. "x" . $this->height . (!empty($this->theme) ? "/" . $this->theme : "");
                
            default:
                $this->setAttrs(array("src" => $this->source));
                
                parent::render();
                break;
        }
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }
    /**
     * @return the $width
     */
    public function getWidth()
    {
        return $this->width;
    }
    
    /**
     * @return the $height
     */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
     * @return the $alt
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * @return the $source
     */
    public function getSource()
    {
        return $this->source;
    }
    
    /**
     * @return the $source
     */
    public function getSrc()
    {
        return $this->source;
    }
    
    /**
     * @param Ambigous <NULL, array> $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }
    
    /**
     * @param Ambigous <NULL, array> $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    
    /**
     * @param Ambigous <string, array> $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }
    
    /**
     * @param Ambigous <string, array> $source
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }
    
    /**
     * @param Ambigous <string, array> $source
     */
    public function setSrc($source)
    {
        $this->source = $source;
        return $this;
    }
    
    /**
     * @return the $theme
     *
     public function getTheme()
     {
     return $this->theme;
     }
     
     /**
     * @param field_type $theme, [sky|vine|lava|gray|industrial|social]
     *
     public function setTheme($theme)
     {
     $_options = array ("sky", "vine", "lava", "gray", "industrial", "social");
     if (in_array($theme, $_options)) {
     $this->theme = $theme;
     } else {
     $this->theme = "";
     }
     
     return $this;
     }
     */
    
}

