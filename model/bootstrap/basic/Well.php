<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Well extends Typography
{
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:well", $vars, $attr);
    }
    
    /**
     * @desc add a h1 tag for text.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        if (!empty($this->text)) {
            $_text = preg_split("/[\n\r]/", $this->text);
            if (!empty($_text)) {
                foreach ($_text as $t) {
                    $p = new HtmlTag("p");
                    $p->setText($t);
                    
                    $this->innerElements [] = $p;
                    unset ($p);
                }
            }
            unset ($this->text);
        }
        
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }

}



