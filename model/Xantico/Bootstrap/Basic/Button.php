<?php

namespace Xantico\Bootstrap\Basic;

class Button extends Typography
{
    protected $isBlock; // boolean
    protected $isSubmit; // boolean
    protected $isReset; // boolean
    protected $isDisabled; // boolean
    protected $isOutline; // boolean
    protected $isLink; // boolean; use a tag
    protected $isActive; // boolean
    protected $url; // string

    public function __construct($text = "", $vars = array(), $attr = array())
    {
        $this->url = key_exists('url', $vars) ? $vars ['url'] : "";
        if (!empty($this->url)) {
            parent::__construct("a:btn", $vars, $attr);
        } else {
            parent::__construct("button:btn", $vars, $attr);
        }

        $this->innerText = $text;
        $this->isBlock = isset($vars['isBlock']) ? $vars ['isBlock'] : false;
        $this->isSubmit = isset($vars['isSubmit']) ? $vars ['isSubmit'] : false;
        $this->isReset = isset($vars['isReset']) ? $vars ['isReset'] : false;
        $this->isDisabled = isset($vars['isDisabled']) ? $vars ['isDisabled'] : false;
        // $this->isOutline    = isset($vars['isOutline']) ? $vars ['isOutline'] : false;
        $this->isLink = isset($vars['isLink']) ? $vars ['isLink'] : false;
        $this->context = !empty($this->context) ? $this->context : "default"; // btn default color scene.

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {
//         $jQuery = "";
        $class = array();
        if ($this->isLink == true) $class [] = "btn-link";
        else if (!empty($this->context)) $class [] = "btn-" . $this->context;
        if (!empty($this->size)) $class [] = "btn-" . $this->size;
        if (!empty($this->border)) $class [] = "btn-" . $this->border;
        if ($this->isBlock == true) $class [] = "btn-block";
        if ($this->isOutline == true) $class [] = "btn-outline";
        if ($this->isActive == true) $class [] = "active";

        $buttonAttrs = array();
        if (!empty($this->title)) $buttonAttrs ['title'] = $this->title;
        if (!empty($this->url)) {
            $this->setTagName("a"); // 把按鈕改為 a 標籤
            $buttonAttrs ['href'] = $this->url;
            if ($this->isDisabled == true) $class [] = "disabled";
        } else {
            if ($this->isSubmit == true) $buttonAttrs ['type'] = "submit";
            else if ($this->isReset == true) $buttonAttrs ['type'] = "reset";
            else                                $buttonAttrs ['type'] = "button";
            if ($this->isDisabled == true) $buttonAttrs ['disabled'] = "disabled";
        }

        $this->appendCustomClass($class);
        $this->appendAttrs($buttonAttrs);

        parent::render();

//         $this->jQuery .= $jQuery;

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @param string $Context
     * default
     * primary
     * info
     * success
     * warning
     * danger
     * inverse
     * pink
     * yellow
     * purple
     * grey
     * light
     * white
     */
    public function setContext($Context = "default")
    {
        $this->context = strtolower($Context);
        return $this;
    }

    /**
     * @param boolean $isSubmit
     */
    public function setIsSubmit($isSubmit = true)
    {
        $this->isSubmit = $isSubmit;
        return $this;
    }

    /**
     * @param field_type $url
     */
    public function setUrl($url = "")
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @desc disabled button
     * @param string $isDisabled
     * @return boolean
     */
    public function setIsDisabled($isDisabled = true)
    {
        $this->isDisabled = $isDisabled;

        return true;
    }

    /**
     * @return boolean $isOutline
     */
    public function getIsOutline()
    {
        return $this->isOutline;
    }

    /**
     * @param field_type $isOutline
     */
    public function setIsOutline($isOutline = true)
    {
        $this->isOutline = $isOutline;
        return $this;
    }

    /**
     * @return the $isBlock
     */
    public function getIsBlock()
    {
        return $this->isBlock;
    }

    /**
     * @param field_type $isBlock
     */
    public function setIsBlock($isBlock = true)
    {
        $this->isBlock = $isBlock;
        return $this;
    }

    /**
     * @return the $isReset
     */
    public function getIsReset()
    {
        return $this->isReset;
    }

    /**
     * @param field_type $isReset
     */
    public function setIsReset($isReset = true)
    {
        $this->isReset = $isReset;
        return $this;
    }

    /**
     * @return the $isLink
     */
    public function getIsLink()
    {
        return $this->isLink;
    }

    /**
     * @param Ambigous $isLink
     */
    public function setIsLink($isLink = true)
    {
        $this->isLink = $isLink;
        return $this;
    }

    /**
     * @return the $isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param field_type $isActive
     */
    public function setIsActive($isActive = true)
    {
        $this->isActive = $isActive;
        return $this;
    }


}
