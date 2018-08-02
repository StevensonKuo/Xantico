<?php
namespace model\bootstrap\basic;


class Input {
    protected $id;
    protected $inputType;
    protected $type;
    protected $text;
    protected $placeholder;
    protected $colorSet;
    protected $mode;
    protected $name;
    protected $defaultValue;
    protected $labelRatio;
    protected $width;
    protected $spinnerVars; // for number type.
    protected $options; // for checkbox and radio.
    protected $textColorSet;
    protected $caption; // string
    protected $defaultOption = array (); // for radio and checkbox.
    protected $customClass = array (); 
    protected $isDisabled; // boolean
    protected $isStatic; // boolean
    protected $icon; // Icon
    protected $iconAlign; // string
    protected $display = "block"; // string
    protected $formType; // string
    protected $html; // string
    protected $jQuery; // string

    /**
     * 建構子
     * @param string $inputType
     * @param array $vars
     * @return \model\bootstrap\basic\Input
     */
    public function __construct($inputType = "text", $vars = array ())
    {
        $this->inputType    = $inputType ? strtolower($inputType) : "text";
        $this->type         = key_exists('type', $vars) ? $vars ['type'] : "horizontal";
        if ($this->inputType == "hidden") $this->type = "hidden";
        $this->text         = key_exists('text', $vars) ? $vars ['text'] : "";
        $this->placeholder  = key_exists('placeholder', $vars) ? $vars ['placeholder'] : "";
        $this->caption      = key_exists('caption', $vars) ? $vars ['caption'] : "";
        $this->colorSet     = key_exists('colorSet', $vars) ? $vars ['colorSet'] : "info";
        $this->textColorSet = key_exists('textColorSet', $vars) ? $vars ['textColorSet'] : "";
        $this->mode         = key_exists('mode', $vars) ? $vars ['mode'] : "";
        $this->defaultValue = key_exists('defaultValue', $vars) ? $vars ['defaultValue'] : 
                                ($this->inputType != "number" ? "" : "0");
        $this->id           = key_exists('id', $vars) ? $vars ['id'] : "";
        $this->name         = key_exists('name', $vars) ? $vars ['name'] : "";
        $this->labelRatio   = (key_exists('labelRatio', $vars) && is_array($vars)) ? $vars ['labelRatio'] : array (3, 9); // 字寬３欄寬９
        $this->width        = key_exists('width', $vars) ? (is_numeric($vars ['width']) ? 
                                $vars ['width'] : explode("/", $vars ['width'])) : null;
        $this->spinnerVars  = array ("min" => 0, "max" => 999999999, "step" => 1);
        // icon.
        $this->icon         = key_exists('icon', $vars) ? $vars ['icon'] : NULL;
        $this->iconAlign    = key_exists('iconAlign', $vars) ? $vars ['iconAlign'] : "right";
        
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
     * @param string $text
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        
        return $this;
    }
    
    /**
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
        
        return $this;
    }
    
    /**
     * @param string $colorSet
     */
    public function setColorSet($colorSet)
    {
        $this->colorSet = $colorSet;
        
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
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        
        return $this;
    }
    
    /**
     * 用在 horizontal 的表單裡，label 和 input 框的比例用
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function setLabelRatio($labelRatio)
    {
        $this->labelRatio = $labelRatio;
        
        return $this;
    }
    
    /**
     * 數字表單專用，range 設定。
     * @param array $vars
     * @return \model\bootstrap\basic\Input
     */
    function setNumberVars ($vars = array ()) {
        if ($this->inputType == "number") {
            // value:0,min:0,max:200,step:10
            $this->spinnerVars ['max'] = $vars ['max'] ? $vars ['max'] : 200;
            $this->spinnerVars ['min'] = $vars ['min'] ? $vars ['min'] : 0;
            $this->spinnerVars ['step'] = $vars ['step'] ? $vars ['step'] : 1;
        }
        
        return $this;
    }
    
    /**
     * @param array $options
     */
    public function setOptions($options = array ())
    {
        $this->options = $options;
        
        return $this;
    }
    
    /**
     * @desc width/12
     * @param string $width
     * @return \model\bootstrap\basic\Input
     */
    public function setWidth ($width = "12") {
        $this->width = $width;
        return $this;
    }
    
    /**
     *
     * @param array $option
     * @return \Bootstrap\Aceadmin\Input
     */
    public function setDefaultOption ($option = array ()) {
        if (!is_array($option)) $option = array ($option);
        $this->defaultOption = $option;
        
        return $this;
    }
    
    /**
     *
     * @param array $option
     * @return \Bootstrap\Aceadmin\Input
     */
    public function setCustomClass($customClass = array ())
    {
        if (!is_array ($customClass)) $customClass = array ($customClass);
        $this->customClass = array_merge($this->customClass, $customClass);
        
        return $this;
    }
    
    /**
     * @param Ambigous <string, unknown> $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * @param Ambigous <string, unknown> $textColorSet
     */
    public function setTextColorSet($textColorSet)
    {
        $this->textColorSet = $textColorSet;
        return $this;
    }
    
    /**
     * $jQuery getter.
     * @return string
     */
    public function getJQuery () {
        return $this->jQuery;
    }
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Caption 是標題，Text 是內文
     * @return the $caption
     */
    public function getCaption()
    {
        return $this->caption ? $this->caption : $this->text;
    }
    
    /**
     * @param string <string, unknown> $mode
     */
    public function setMode($mode)
    {
        // large/normal
        $this->mode = $mode;
        return $this;
    }
    
    /**
     *
     * @param unknown $isDisabled
     * @return \Bootstrap\Aceadmin\Input
     */
    public function setDisabled($isDisabled = true)
    {
        $this->isDisabled = $isDisabled;
        return $this;
    }
    /**
     * @return the $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    /**
     * 取得 Icon 排版
     * @return the $iconAlign
     */
    public function getIconAlign()
    {
        return $this->iconAlign;
    }
    
    /**
     * @param Icon $icon
     */
    public function setIcon(Icon $icon)
    {
        $this->icon = $icon;
        return $this;
    }
    
    /**
     * 設定 Icon 排版，排右邊排左邊
     * @param Ambigous <NULL, unknown> $iconAlign [right/left]
     */
    public function setIconAlign($iconAlign)
    {
        if (!in_array($iconAlign, array ("left", "right")))
            $iconAlign = "left";
            
            $this->iconAlign = $iconAlign;
            return $this;
    }
    /**
     * @return the $display
     */
    public function getDisplay()
    {
        return $this->display;
    }
    
    /**
     * @param field_type $display
     */
    public function setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }
    
    /**
     * @return the $formType
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param field_type $formType
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
        return $this;
    }
    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return the $isStatic
     */
    public function getIsStatic()
    {
        return $this->isStatic;
    }

    /**
     * @param field_type $isStatic
     */
    public function setIsStatic($isStatic = true)
    {
        $this->isStatic = $isStatic;
        
        return $this;
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



