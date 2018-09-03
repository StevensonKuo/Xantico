<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class PageHeader extends Typography
{
    public function __construct($text, $vars = array (), $attr = array ())
    {
        parent::__construct("div:page-header", $vars, $attr);
        
        
        $this->text = $text;
    }
    
    /**
     * @desc add a h1 tag for text.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        $h1 = new HtmlTag("h1");
        $h1->setText($this->text);
        unset ($this->text);
        
        $this->innerElements [] = $h1;
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }

}



