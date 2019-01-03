<?php

namespace Xantico\Bootstrap\Basic;

use Xantico\Bootstrap\HtmlTag;

class Image extends Typography
{
    public static $BOOTSTRAP_IMAGE_DEFAULT_WIDTH = 200; // string
    public static $BOOTSTRAP_IMAGE_DEFAULT_HEIGHT = 200; // int, or %

    private static $shapeArr = array("rounded", "circle", "thumbnail", ""); // int, or %

    protected $shape; // string
    protected $width; // string
    protected $height; // string
    protected $alt; // boolean
    //     protected $theme;
    protected $source;
    protected $url;
    protected $isResponsive;

    /**
     * @param unknown $type
     * @param array $vars
     * @param array $attrs
     * @return \model\Xantico\basic\Typography
     */
    public function __construct($shape = "", $vars = array(), $attrs = array())
    {
        $shape = strtolower($shape);
        if (!in_array($shape, self::$shapeArr)) $shape = "";
        parent::__construct("img" . (!empty($shape) ? ":img-" . $shape : ""), $vars, $attrs);

        $this->shape = $shape;
        $this->width = isset ($vars ['width']) ? $vars ['width'] : null;
        $this->height = isset ($vars ['height']) ? $vars ['height'] : null;
        $this->alt = isset ($vars ['alt']) ? $vars ['alt'] : "";
        $this->source = isset ($vars ['src']) ? $vars ['src'] : "";
        $this->source = isset ($vars ['source']) ? $vars ['source'] : $this->source;
        $this->isResponsive = isset ($vars ['isResponsive']) ? $vars ['isResponsive'] : false;
        //         $this->theme    = isset ($vars ['theme']) ? $vars ['theme'] : "";

    }

    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if (!empty($this->width)) {
            $this->appendAttrs(array("width" => $this->width));
        }
        if (!empty($this->height)) {
            $this->appendAttrs(array("height" => $this->height));
        }
        if (!empty($this->alt)) {
            $this->appendAttrs(array("alt" => $this->alt));
        }

        if (empty($this->width)) $this->width = self::$BOOTSTRAP_IMAGE_DEFAULT_WIDTH;
        if (empty($this->height)) $this->height = self::$BOOTSTRAP_IMAGE_DEFAULT_HEIGHT;
//         $this->source = $this->source . "/" . $this->width. "x" . $this->height . (!empty($this->theme) ? "/" . $this->theme : "");
        $this->appendAttrs(array("src" => $this->source));

        parent::render();

        if (!empty($this->url)) {
            $a = new HtmlTag("a");
            $a->appendAttrs(array("href" => $this->url))->appendCustomClass("thumbnail");
            $a->setInnerHtml($this->html);
            $this->html = $a->render();
        }

        if (!empty($this->caption)) {
            $div = new HtmlTag("div");
            $div->appendCustomClass("thumbnail");
            $divCaption = new Typography("div:caption");
            if (is_string($this->caption)) {
                $captionP = new HtmlTag("p");
                $captionP->setText($this->caption);
                $divCaption->appendInnerElements($captionP);
            } else {// instance or array. 
                $divCaption->appendInnerElements($this->caption);
            }
            $div->appendInnerElements($this->html, $divCaption);
            $this->html = $div->render();
        }

        if ($display == true) {
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
     * @param Ambigous <NULL, array> $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return the $height
     */
    public function getHeight()
    {
        return $this->height;
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
     * @return the $alt
     */
    public function getAlt()
    {
        return $this->alt;
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
     * @return the $source
     */
    public function getSource()
    {
        return $this->source;
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
     * @return the $source
     */
    public function getSrc()
    {
        return $this->source;
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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @param $shape
     * @return $this
     */
    public function setShape($shape)
    {
        $shape = strtolower($shape);
        if (in_array($shape, self::$shapeArr)) {
            $this->shape = $shape;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsResponsive()
    {
        return $this->isResponsive;
    }

    /**
     * @param field_type $isResponsive
     */
    public function setIsResponsive($isResponsive = true)
    {
        $this->isResponsive = $isResponsive;
        return $this;
    }

    public function setShapeRounded()
    {
        $this->shape = "rounded";
        return $this;
    }

    public function setShapeCircle()
    {
        $this->shape = "circle";
        return $this;
    }

    public function setShapeThumbnail()
    {
        $this->shape = "thumbnail";
        return $this;
    }


}

