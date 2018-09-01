<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Jumbotron extends Typography
{
    protected $header; // string
    protected $contents; // string, instead of text.
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:jumbotron", $vars, $attr);
        
        $this->header   = isset ($vars ['header']) ? $vars ['header'] : "";
        $this->contents = isset ($vars ['text']) ? $vars ['text'] : "";
        // text 在 parent 裡會設
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $header = New Typography("h1", array ("text" => $this->header));
        $text = New Typography("p", array ("text" => $this->contents));
        
        $this->setInnerElements(array ($header, $text));
        
        parent::render();
        
        if ($display) {
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
    public function getText()
    {
        return $this->contents;
    }

    /**
     * @param Ambigous <string, array> $contents
     */
    public function setText($contents)
    {
        $this->contents = $contents;
        return $this;
    }

    
    
}


