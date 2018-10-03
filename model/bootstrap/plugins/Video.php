<?php
namespace model\bootstrap\plugins;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;
use model\bootstrap\iCaption;
use model\bootstrap\Xantico;

class Video extends Typography
{
    protected $source; // array, video source. with video type.
    protected $poster; // string, video cover.
    protected $track; // array, subtitle. with options
    protected $withControls; // boolean. 
    protected $moduleType; // string
    protected $dataVideoId; // strint, for youtube.
    protected $setup; // array
    
    private static $moduleTypeArr = array ("html5", "plyr", "");
    private static $modeArr = array ("video", "audio", "youtube");
    
    const PLYR_CSS_CDN_URL = "https://cdn.plyr.io/3.4.3/plyr.css";
    const PLYR_JS_CDN_URL = "https://cdn.plyr.io/3.4.3/plyr.js";
    const PLYR_SPRITE_SVG_CDN_URL = "https://cdn.plyr.io/1.3.5/sprite.svg";
    
    /**
     * @param array $vars
     * @param array $attr
     */
    public function __construct($source = "", $vars = array (), $attr = array())
    {
        parent::__construct("div:player", $vars, $attr);
        
        $this->source           = $source;
        $this->poster           = isset ($vars ['poster']) ? $vars ['poster'] : "";
        $this->track            = isset ($vars ['track']) ? $vars ['track'] : "";
        $this->withControls     = isset ($vars ['withControls']) ? $vars ['withControls'] : false;
        $this->moduleType       = isset ($vars ['moduleType']) ? $vars ['moduleType'] : "html5";
        $this->dataVideoId      = isset ($vars ['dataVideoId']) ? $vars ['dataVideoId'] : "";
        $this->setup            = isset ($vars ['setup']) ? $vars ['setup'] : array();
        $this->mode             = !empty($this->mode) ? $this->mode : "video";
    }
    
    /**
     * generate html.
     * @param string $display
     */
    public function render ($display = false) {
        
        $jQuery = "";
//         $this->embedResponsive = "16:9";
        switch ($this->moduleType) {
            default:
            case "html5":
            case "plyr":
                // add plugin css and js path.
                if (!in_array(Video::PLYR_CSS_CDN_URL, Xantico::$defaultCSSFiles)) {
                    Xantico::$defaultCSSFiles [] = self::PLYR_CSS_CDN_URL;
                }
                if (!in_array(Video::PLYR_JS_CDN_URL, Xantico::$defaultScriptsFiles)) {
                    Xantico::$defaultScriptsFiles [] = self::PLYR_JS_CDN_URL;
                }
                
                switch ($this->mode) {
                    case "video":
                        $video = new Typography("video", array ("crossorigin" => "crossorigin"));
                        $video->setId();
                        if ($this->withControls == true) $video->setAttrs(array ("controls" => "controls"));
                        if (!empty($this->poster)) $video->setAttrs(array ("poster" => $this->poster));
                        
                        $innerVideo = array ();
                        if (!empty($this->source) && !is_array ($this->source)) {
                            $_source = array(array ("src" => $this->source, "size" => 720));
                            $this->source = $_source;
                        }
                        foreach ($this->source as $src) {
                            
                            if (!isset ($src ['type'])) {
                                $_type = explode(".", basename($src ['src']));
                                $_type = "video/" . $_type [@count($_type) - 1];
                                if (!$_type) {
                                    $_type = "video/mp4"; // default
                                }
                            } else {
                                $_type = $src ['type'];
                            }
                            $innerVideo [] = new HtmlTag("source", array (
                                "src" => $src ['src'], 
                                "type" => $_type 
                            ));
                            unset ($_type);
                        }
                        
                        if (!empty($this->track)) {
                            $track = new HtmlTag("track", $this->track);
                            $innerVideo [] = $track;
                        }
                        
                        if (!empty($_href)) {
                            $_href = is_array ($this->source) ? $this->source [0] ['src'] : $this->source;
                            $download = new HtmlTag("a", array ("href" => $_href));
                            // for browser who didn't support video tag.
                            $download->setText(iCaption::CAP_DOWNLOAD);
                            $innerVideo [] = $download;
                        }
                        
                        if (count($innerVideo) > 0) $video->setInnerElements($innerVideo);
                        $this->innerElements [] = $video;
                        break;
                    case "audio":
                        $audio = new HtmlTag("audio", array ("crossorigin" => "crossorigin"));
                        if ($this->withControls == true) $video->setAttrs(array ("controls" => "controls"));
                        
                        $innerAudio = array ();
                        if (is_array ($this->source)) {
                            foreach ($this->source as $src) {
                                if (!isset ($src ['type'])) {
                                    $_type = explode(".", basename($src ['src']));
                                    $_type = "type/" . $_type [@count($_type) - 1];
                                    if (!$_type) {
                                        $_type = "audio/mp3"; // default
                                    }
                                } else {
                                    $_type = $src ['type'];
                                }
                                $innerAudio [] = new HtmlTag("source", array ("src" => $src ['src'], "type" => $_type));
                                unset ($_type);
                            }
                        } else {
                            $audio->setAttrs(array ("src" => $this->source));
                        }
                        
                        if (!empty($this->track)) {
                            $track = new HtmlTag("track", $this->track);
                            $innerAudio [] = $track;
                        }
                        
                        $_href = is_array ($this->source) ? $this->source [0] ['src'] : $this->source;
                        if (!empty($_href)) {
                            $download = new HtmlTag("a", array ("href" => $_href));
                            // for browser who didn't support video tag.
                            $download->setText(iCaption::CAP_DOWNLOAD);
                            $innerAudio [] = $download;
                        }
                        
                        if (count($innerAudio) > 0) $audio->setInnerElements($innerAudio);
                        $this->innerElements [] = $audio;
                        break;
                    case "youtube":
                        $youtube = new HtmlTag("div", array (
                            "data-video-id" => "L1h9xxCU20g", 
                            "data-type" => "youtube"
                        ));
                        $this->innerElements [] = $youtube;
                }
                
                $jQuery = "
const player = new Plyr('#".$video->getId()."');
                ";
                
                
                
                break;
        }
        
        parent::render();
        
        $this->jQuery .= $jQuery;
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
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
     * @return the $moduleType
     */
    public function getModuleType()
    {
        return $this->moduleType;
    }

    /**
     * @param field_type $moduleType
     */
    public function setModuleType($moduleType)
    {
        $moduleType = strtolower($moduleType);
        if (in_array($moduleType, self::$moduleTypeArr)) {
            $this->moduleType = $moduleType;
        }
        
        return $this;
        
    }
    
    /**
     * @desc video/audio two types.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setMode()
     */
    public function setMode($mode) {
        $mode = strtolower($mode);
        if (in_array($mode, self::$modeArr)) {
            $this->mode = $mode;
        }
        return $this;    
    }
    
    /**
     * @return the $dataVideoId
     */
    public function getDataVideoId()
    {
        return $this->dataVideoId;
    }

    /**
     * @param field_type $dataVideoId
     */
    public function setDataVideoId($dataVideoId)
    {
        $this->dataVideoId = $dataVideoId;
        return $this;
    }
    
    /**
     * @return the $setup
     */
    public function getSetup()
    {
        return $this->setup;
    }

    /**
     * @param field_type $setup
     */
    public function setSetup($setup = array())
    {
        $this->setup = (array)$setup;
        return $setup;
    }



}


