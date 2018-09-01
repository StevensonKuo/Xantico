<?php
namespace model\bootstrap\basic;

class ButtonToolbar extends Typography 
{
    
    public function __construct($vars = array (), $attr = array())
    {
        parent::__construct("div:btn-toolbar", $vars, $attr);
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc 多做了過濾是不是 btn-group 的動作
     * {@inheritDoc}
     * @see \model\bootstrap\HtmlTag::setInnerElements()
     */
    public function setInnerElements($innerElements = array ())
    {
        if (empty($innerElements)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else {
            if (!is_array($innerElements)) $innerElements = array ($innerElements);
        }
        
        foreach ($innerElements as $k => $ele) { // 把不是 button group 的過瀘掉
            if (!($ele instanceof ButtonGroup)) {
                unset($innerElements[$k]);
                parent::setErrMsg("button toolbar has one element which is not button-group instance." . $ele->getType());
            }
        }
        
        return parent::setInnerElements($innerElements);
    }
    
}
