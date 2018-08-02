<?php
namespace app\admin\model\bootstrap\hplus;

use app\admin\model\bootstrap\hplus\Typography;

class Image extends \app\admin\model\bootstrap\basic\Image
{
    protected $source; // string, img url.
    protected $thumb; // string. additional defined thumbsnail pic.
//     protected $width; // int, traditional width, when thumb didn't work.
//     protected $height; // int, traditional height. when thumb didn't work.
    protected $effect; // string [none|elastic|fade]
    protected $gallery; // multiple pic set.
    /**
     * generate html.
     * @param string $display
     */
    public function render ($display = false) {
        $html = "";
        $jQuery = "";
        switch ($this->type) {
            default:
            case "fancybox":
                $oClass = $this->customClass;
                $oClass [] = "fancybox";
                $href   = $this->source;
                $src    = $this->thumb ? $this->thumb : $this->source;
                $title  = $this->text;
                $a = new Typography("a", null, array ("href" => $href, "title" => $title, "rel" => "gallery1"));
                $a->setCustomClass($oClass);
                $img = new Typography("img", null, array ("src" => $src, "alt" => $title));
//                 if ($this->width) $img->setAttrs(array("width" => $this->width));
//                 if ($this->height) $img->setAttrs(array("height" => $this->height));
                $a->setInnerElements(array ($img));
                
                $html = $a->render();
                
                $jQuery = "
                    $(document).ready(function () {
                        $('.fancybox').fancybox({
                            openEffect: '{$this->effect}',
                            closeEffect: '{$this->effect}',
                            prevEffect: '',
                            nextEffect: '',
                            helpers: {
                                overlay: {
                                  locked: false
                                }
                            }
                        });
                    });
                ";
                break;
        }
        
        $this->html = $html;
        $this->jQuery = $jQuery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    /**
     * @return the $source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return the $thumb
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @param field_type $source
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param field_type $thumb
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
        return $this;
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
     * @param field_type $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param field_type $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    /**
     * @return the $effect
     */
    public function getEffect()
    {
        return $this->effect;
    }

    /**
     * @desc fancybox open/close effect. [none|elastic|fade] (default: none)
     * @param field_type $effect
     */
    public function setEffect($effect = "none")
    {
        $this->effect = $effect;
        return $this;
    }



    

    
}


