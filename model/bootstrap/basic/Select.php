<?php
namespace model\bootstrap\basic;

class Select 
{
    protected $id; // string
    protected $inputType; // string
    protected $text; // string
    protected $name; // string
    protected $options = array ();
    protected $defaultOption;
    protected $formType; // string
    protected $width; // string
    protected $html; // string
    protected $jQuery; // string
    
    public function __construct($options = array (), $text = "", $colorSet = "", $defaultValue = "", $id = "", $name = "", $placeholder = "", Icon $icon = null, $labelRatio = array (3, 9))
    {
        // text, radio, checkbox, button, submit, reset
        $this->inputType = "select";
        $this->text = $text;
        $this->id = $id;
        $this->name = $name;
        $this->options = $options;
        $this->labelRatio = $labelRatio ? $labelRatio : array (3, 9); // 字寬３欄寬９
        // icon.
        $this->icon = $icon ? $icon : NULL;
        
        return $this;
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        if ($display)
            echo $this->html;
            else
                return $this->html;
    }
    
    /**
     * magic function to string.
     *
     * @return string
     */
    function __toString()
    {
        if ($this->html)
            return $this->html;
            else
                return $this->render();
    }
    
    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
        
        return $this;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * @param string $defaultValue
     */
    public function setOptions($options = array ())
    {
        $this->options = $options;
        
        return $this;
    }

    /**
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function setLabelRatio($labelRatio)
    {
        $this->labelRatio = $labelRatio;
        
        return $this;
    }

    
    public function setWidth ($width = "5/10") {
        if (preg_match("/{0-9}+\/{0-9}+/", $this->width)) $this->width = explode ("/", $width); // 使用比率
        else $this->width = $width;
        return $this;
    }
    
    public function setDefaultOption ($option) {
        $this->defaultOption = $option;
        
        return $this;
    }
    /**
     * @return the $jQuery
     */
    public function getJQuery()
    {
        return $this->jQuery;
    }
    /**
     * @return the $formType
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * Form 的 Style, 應該有 inline, horizontal, fieldset etc... 
     * @param field_type $formType
     * return self
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }

    public function setCaption ($text) {
        return $this->setText($text);
    }
    /**
     * @param field_type $jQuery
     */
    public function setJQuery($jQuery)
    {
        $this->jQuery = $jQuery;
        return $this;
    }


}



