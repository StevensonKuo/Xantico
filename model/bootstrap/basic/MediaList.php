<?php
namespace model\bootstrap\basic;

class MediaList extends Typography 
{
 
    public function __construct($vars = array (), $attr = array())
    {
        parent::__construct("ul:media-list", $vars, $attr);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        
        if (!empty($this->innerElements)) {
            foreach ($this->innerElements as &$ele) {
                if ($ele instanceof Media) {
                    $ele->setTagName("li");
                }
            }
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

}
