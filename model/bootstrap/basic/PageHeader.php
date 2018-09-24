<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class PageHeader extends Typography
{
    protected $header; // string
    protected $subText; // string;
    
    public function __construct($header, $vars = array (), $attr = array ())
    {
        parent::__construct("div:page-header", $vars, $attr);
        
        $this->subText  = isset($vars ['subtext']) ? $vars ['subtext'] : "";
        $this->header   = isset($vars ['header']) ? $vars ['header'] : $header;
    }
    
    /**
     * @desc add a h1 tag for text.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        $h1 = new HtmlTag("h1");
        $h1->setInnerElements($this->header);
        if (!empty($this->subText)) {
            $_small = new HtmlTag("small");
            $_small->setText($this->subText);
            $h1->setInnerElements($_small);
        }
        $this->text = "";
        
        $this->innerElements [] = $h1;
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }
    
    /**
     * @return the $subText
     */
    public function getSubText()
    {
        return $this->subText;
    }

    /**
     * @param Ambigous <string, array> $subText
     */
    public function setSubText($subText)
    {
        $this->subText = $subText;
        return $this;
    }


}



