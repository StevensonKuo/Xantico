<?php
namespace model\bootstrap\basic;

class ButtonToolbar extends Typography 
{
    
    public function __construct($innerElements = array (), $vars = array (), $attr = array())
    {
        parent::__construct("div:btn-toolbar", $vars, $attr);
        
        $this->innerElements = $innerElements;
    }
    
    /**
     * @desc add filter of buttons.
     * {@inheritDoc}
     * @see \model\bootstrap\HtmlTag::appendInnerElements()
     */
    public function appendInnerElements($innerElements = array ())
    {
        if (empty($innerElements)) return $this;
        $numargs = func_num_args();
        if ($numargs >= 2) {
            $innerElements = func_get_args();
        } else {
            if (!is_array($innerElements)) $innerElements = array ($innerElements);
        }
        
        foreach ($innerElements as $k => $ele) { // fliter buttons.
            if (!($ele instanceof ButtonGroup)) {
                unset($innerElements[$k]);
                parent::setErrMsg("button toolbar has one element which is not button-group instance." . $ele->getType());
            }
        }
        
        return parent::appendInnerElements($innerElements);
    }
    
}
