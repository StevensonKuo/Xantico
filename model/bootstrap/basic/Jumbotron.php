<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Jumbotron extends Typography
{
    protected $header; // string
    protected $bodyContents; // string, instead of text.
    protected $isFullWidth; // boolean
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:jumbotron", $vars, $attr);
        
        $this->header       = isset ($vars ['header']) ? $vars ['header'] : "";
        $this->bodyContents = isset ($vars ['bodyContents']) ? $vars ['bodyContents'] : array();
        $this->isFullWidth  = isset ($vars ['isFullWidth']) ? $vars ['isFullWidth'] : array();
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $header = New Typography("h1", array ("innerText" => $this->header));
        if ($this->isFullWidth == true) {
            $cntnr = new Container();
            $cntnr->appendInnerElements($header);
        } else {
            $this->innerElements [] = $header;
        }
        
        if (!empty($this->bodyContents)) {
            foreach ($this->bodyContents as $body) {
                if (is_string($body)) {
                    $paragraph = explode ("\n", $body);
                    foreach ($paragraph as $p) {
                        $_text = New Typography("p");
                        $_text->setText($p);
                        if ($this->isFullWidth == true && isset($cntnr)) {
                            $cntnr->appendInnerElements($_text);
                        } else {
                            $this->innerElements [] = $_text;
                        }
                        unset ($_text);
                    }
                } else {
                    if ($this->isFullWidth == true && isset($cntnr)) {
                        $cntnr->appendInnerElements($body);
                    } else {
                        $this->innerElements [] = $body;
                    }
                }
            }
            
            $this->bodyContents = null;
        }
        
        if ($this->isFullWidth == true && isset($cntnr)) {
            $this->innerElements [] = $cntnr;
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @return the $header
     */
    public function getHeader()
    {
        return $this->header;
    }
    
    /**
     * @param Ambigous <string, array> $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }
    
    /**
     * @return the $contents
     */
    public function getBodyContents()
    {
        return $this->bodyContents;
    }
    
    /**
     * @param Ambigous <multitype:, field_type> $bodyContents
     */
    public function appendBodyContents($bodyContents = array ())
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
     * @desc setter, merge all argvs.
     * @param array $bodyContents
     * @return \model\bootstrap\basic\Jumbotron
     */
    public function setBodyContents($bodyContents = array ())
    {
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $bodyContents = func_get_args();
        } else {
            if (!is_array($bodyContents)) $bodyContents = array ($bodyContents);
        }
        
        $this->bodyContents = $bodyContents;
        
        return $this;
    }
    
    public function getBody ($index) {
        if (isset($this->bodyContents [$index])) {
            return $this->bodyContents [$index];
        } else {
            return null;
        }
    }
    
    public function setBody ($index, $content) {
        $this->bodyContents [$index] = $content;
        return $this;
    }
    
    /**
     * @return the $isFullWidth
     */
    public function getIsFullWidth()
    {
        return $this->isFullWidth;
    }

    /**
     * @param Ambigous <multitype:, array> $isFullWidth
     */
    public function setIsFullWidth($isFullWidth = true)
    {
        $this->isFullWidth = $isFullWidth;
        return $this;
    }

    
    
}


