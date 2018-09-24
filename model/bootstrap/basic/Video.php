<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\iCaption;

class Video extends Typography
{
    protected $poster; // string, video cover.
    protected $source; // array, video source. with video type.
    protected $track; // array, subtitle. with options
    protected $downloadable; // boolean, if downloadable.
    protected $withControls; // boolean. 
    protected $width; // int, 1~12
    
    /**
     * generate html.
     * @param string $display
     */
    public function render ($display = false) {
        $html = "";
        $jQuery = "";
        if (empty($this->width)) $this->width = 6;
        switch ($this->type) {
            default:
            case "html5":
                break;
            case "plyr":
                $oClass = $this->customClass;
                $oClass [] = "player";
                $div = new Typography("div");
                $div->setCustomClass($oClass);
                $video = new Typography("video", null, array ("crossorigin" => "crossorigin"));
                if ($this->withControls == true) $video->setAttrs(array ("controls" => "controls"));
                if (!empty($this->poster)) $video->setAttrs(array ("poster" => $this->poster));
                
                $innerVideo = array ();
                if (is_array ($this->source)) {
                    foreach ($this->source as $src) {
                        if (!isset ($src ['type'])) {
                            $_type = explode(".", basename($src ['src']));
                            $_type = "type/" . $_type [@count($_type) - 1];
                            if (!$_type) {
                                $_type = "type/mp4"; // default
                            }
                        } else {
                            $_type = $src ['type'];
                        }
                        $innerVideo [] = new Typography("source", array (), array ("src" => $src ['src'], "type" => $_type));
                        unset ($_type);
                    }
                } else {
                    $video->setAttrs(array ("src" => $this->source));
                }
                
                if ($this->track) {
                    $track = new Typography("track", null, $this->track);
                    $innerVideo [] = $track;
                }
                
                
                if ($this->downloadable) {
                    $_href = is_array ($this->source) ? $this->source [0] ['src'] : $this->source;
                    $download = new Typography("a", null, array ("href" => $_href)); // default to download the 1st video.
                    $download->setText(iCaption::CAP_DOWNLOAD);
                    $innerVideo [] = $download;
                }
                
                if (count($innerVideo) > 0) $video->setInnerElements($innerVideo);
                $div->setCustomClass("col-sm-" . $this->width)
                    ->setInnerElements($video);
                $divRow = new Typography("div");
                $divRow->setCustomClass("row")
                    ->setInnerElements($div);

                $html = $divRow->render();
                
                $jQuery = "
                    (function (d, u) {
                        var a = new XMLHttpRequest(),
                            b = d.body;
            
                        // Check for CORS support
                        // If you're loading from same domain, you can remove the if statement
                        if ('withCredentials' in a) {
                            a.open('GET', u, true);
                            a.send();
                            a.onload = function () {
                                var c = d.createElement('div');
                                c.setAttribute('hidden', '');
                                c.innerHTML = a.responseText;
                                b.insertBefore(c, b.childNodes[0]);
                            }
                        }
                    })(document, '/static/admin/css/plugins/plyr/sprite.svg');
        
                    plyr.setup();
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
     * @return the $poster
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @return the $source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return the $track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @return the $downloadable
     */
    public function getDownloadable()
    {
        return $this->downloadable;
    }

    /**
     * @param field_type $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
        return $this;
    }

    /**
     * @desc [["src" => $src, "type" => $type]]
     * @param field_type $source
     */
    public function setSource($source = array ())
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @param string $track
     */
    public function setTrack($track = "")
    {
        $this->track = $track;
        return $this;
    }

    /**
     * @param field_type $downloadable
     */
    public function setDownloadable($downloadable = false)
    {
        $this->downloadable = $downloadable;
        return $this;
    }
    /**
     * @return the $withControls
     */
    public function getWithControls()
    {
        return $this->withControls;
    }

    /**
     * @param field_type $withControls
     */
    public function setWithControls($withControls = true)
    {
        $this->withControls = $withControls;
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
     * @param number $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }




    

    
}


