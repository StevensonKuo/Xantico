<?php
namespace model\bootstrap\basic;

class Textarea 
{
    protected $type; // string
    protected $caption; // string
    protected $text; // string
    protected $placeholder; // string
    protected $id; // string
    protected $name; // string
    protected $options = array ();
    protected $rows; // int
    protected $cols; // int
    protected $customClass = array (); // array
    protected $customStyle = array (); // array
    protected $isDisabled; // boolean
    protected $isStatic; // boolean
    protected $formType; // string    
    protected $html; // string
    protected $jQuery; // string
    
    public function __construct($type = "", $caption = "", $text = "", $id = "", $name = "", $placeholder = "", $maxlength = null, $labelRatio = array (3, 9))
    {
        // regular, rich-text.
        $this->type = "";
        $this->caption = $caption;
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->id = $id;
        $this->name = $name;
        $this->maxlength = $maxlength;
        $this->labelRatio = $labelRatio ? $labelRatio : array (3, 9); // 字寬３欄寬９
        $this->rows = "5";
        $this->cols = "44";
        
        return $this;
    }
    
    /**
     * @desc 渲染（佔位）
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
     * @desc magic function to string.
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
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function setLabelRatio($labelRatio)
    {
        $this->labelRatio = $labelRatio;
        
        return $this;
    }

    /**
     * set placeholder
     * @param string $placeholder
     * @return \Bootstrap\Aceadmin\Textarea
     */
    public function setPlaceholder ($placeholder = "") {
        $this->placeholder = $placeholder;
        return $this;
    }
    
    /**
     * caption setter.
     * @param string $caption
     * @return \Bootstrap\Aceadmin\Textarea
     */
    public function setCaption ($caption = "") {
        $this->caption = $caption;
        
        return $this;
    }
    
    /**
     * variable jQuery getter.
     */
    public function getJQuery () {
        return $this->jQuery;
    }
    
    /**
     * @param array: $customClass
     */
    public function setCustomClass($customClass = array ())
    {
        if (!is_array ($customClass)) $customClass = array ($customClass);
        $this->customClass = array_merge($this->customClass, $customClass);
        
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
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return the $isDisabled
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }

    /**
     * @param field_type $isDisabled
     */
    public function setIsDisabled($isDisabled = true)
    {
        $this->isDisabled = $isDisabled;
        return $this;
    }
    /**
     * @return the $isStatic
     */
    public function getIsStatic()
    {
        return $this->isStatic;
    }

    /**
     * @desc statice 的會有 default value 的文字，但還是會回送值; disabled 不會。
     * @param field_type $isStatic
     */
    public function setIsStatic($isStatic = true)
    {
        $this->isStatic = $isStatic;
        return $this;
    }
    /**
     * @return the $customStyle
     */
    public function getCustomStyle()
    {
        return $this->customStyle;
    }

    /**
     * @param multitype: $customStyle
     */
    public function setCustomStyle($customStyle = array ())
    {
        if (!is_array($customStyle)) $customStyle = array ($customStyle);
        if ($this->customStyle) $this->customStyle = array_merge($this->customStyle, $customStyle);
        else $this->customStyle = $customStyle;
        return $this;
    }




    
}

