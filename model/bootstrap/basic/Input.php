<?php
namespace model\bootstrap\basic;

use bootstrap\basic\iRequiredInput;

class Input extends Typography implements iRequiredInput {
    protected $inputType; // enum [text|hidden|radio|checkbox|number]
    protected $name; // string
    protected $placeholder; // string
    protected $defaultValue; // string
    protected $labelRatio; // array @todo labelRatio 的方法可能要改
    protected $textColorSet; // label text color set.
    protected $isDisabled; // boolean
    protected $isReadonly; // boolean
    protected $options; // array; for checkbox and radio.
    protected $defaultOption = array (); // array|int|string for radio and checkbox.
    protected $disabledOption = array (); // array|int|string for radio and checkbox.
    protected $isStacked; // boolean, for radios and checkboxes.
    protected $isMultiple; // boolean, for select
    //     protected $spinnerVars; // for number type.
    //     protected $isStatic; //
    //     protected $dataMask; // string 固定格式
    
    private static $inputTypeArr = array ("text", "radio", "checkbox", "select", "button", "submit", "reset", "textarea", "number");
    /**
     * 建構子
     * @param string $inputType
     * @param array $vars
     * @return \model\bootstrap\basic\Input
     */
    public function __construct($inputType = "text", $vars = array (), $attr = array ())
    {
        $inputType = strtolower($inputType);
        $this->inputType    = !empty($inputType) && in_array($inputType, self::$inputTypeArr) ? $inputType : "text";
        
        if (($this->inputType == "radio" || $this->inputType == "checkbox") && !empty($this->options) && count ($this->options) > 1) {
            // multiple choices radio/checkbox will make a div tag.
            parent::__construct("div:form-control", $vars, $attr);
        } else if ($this->inputType == "textarea" || $this->inputType == "select") {
            parent::__construct($this->inputType, $vars, $attr);
        } else { // text etc.
            parent::__construct("input", $vars, $attr);
        }
        
//         if ($this->inputType == "hidden") $this->type = "hidden"; // @todo ?why
        $this->placeholder      = isset($vars ['placeholder']) ? $vars ['placeholder'] : "";
        $this->name             = isset($vars ['name']) ? $vars ['name'] : "";
        $this->textColorSet     = isset($vars ['textColorSet']) ? $vars ['textColorSet'] : "";
        $this->defaultValue     = isset($vars ['defaultValue']) ? $vars ['defaultValue'] : ($this->inputType != "number" ? "" : "0");
        $this->labelRatio       = isset($vars ['labelRatio']) ? $vars ['labelRatio'] : array (3, 9); // 字寬３欄寬９
        $this->options          = isset($vars ['options']) ? $vars ['options'] : array ();
        $this->defaultOption    = isset($vars ['defaultOption']) ? $vars ['defaultOption'] : null;
        $this->disabledOption   = isset($vars ['disabledOption']) ? $vars ['disabledOption'] : null;
        $this->isDisabled       = isset($vars ['isDisabled']) ? $vars ['isDisabled'] : false;
        $this->isReadonly       = isset($vars ['isReadonly']) ? $vars ['isReadonly'] : false;
        $this->isStacked        = isset($vars ['isStacked']) ? $vars ['isStacked'] : false;
        $this->isMultiple       = isset($vars ['isMultiple']) ? $vars ['isMultiple'] : false;
//         $this->spinnerVars  = array ("min" => 0, "max" => 999999999, "step" => 1);
        
    }
    
    /**
     * 渲染（佔位）
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $jQuery = "";
        if (!$this->caption) $this->caption = $this->text;
        
        switch ($this->inputType) {
            case "hidden":
                $this->setAttrs(array ("type" => $this->inputType));
                if (!empty($this->defaultValue)) $this->attrs ["value"] = $this->defaultValue;
                break;
            case "number":
                // @todo 還不確定基本 bootstrap 有沒有數字 input
                break;
            case "button":
            case "reset":
            case "submit":
            case "text":
                $_class = $this->customClass; // @todo 這個動作是不是其他的物件也要統一 ?
                $_attrs = $this->attrs;
                if ($this->isStatic) {
                    // @todo static output
                } else {
                    $class [] = "form-control";
                    $this->setAttrs(array ("type" => $this->inputType));
                    if (!empty($this->placeholder)) $_attrs ["placeholder"] = $this->placeholder;
                    if (!empty($this->defaultValue)) $_attrs ['value'] = $this->defaultValue;
                    if (!empty($this->isDisabled)) $_attrs ["disabled"] = "disabled";
                    if (!empty($this->isReadonly)) $_attrs ["readonly"] = "readonly";
                    if (!empty($this->size)) $_class [] = "form-control-" . $this->size;
                }
                $this->customClass = $_class;
                $this->attrs = $_attrs;
                break;
            case "textarea":
                $_class = $this->customClass; // @todo 這個動作是不是其他的物件也要統一 ?
                $_attrs = $this->attrs;
                if ($this->isStatic) {
                    // @todo static output
                } else {
                    $_class [] = "form-control";
                    if (!empty($this->placeholder)) $_attrs ["placeholder"] = $this->placeholder;
                    if (!empty($this->defaultValue)) $this->text = $this->defaultValue; // @todo what will happen if value contains html tag???
                    if (!empty($this->isDisabled)) $_attrs ["disabled"] = "disabled";
                    if (!empty($this->isReadonly)) $_attrs ["readonly"] = "readonly";
                    if (!empty($this->size)) $_class [] = "form-control-" . $this->size;
                }
                $this->customClass = $_class;
                $this->attrs = $_attrs;
                break;
            case "select":
                if ($this->isMultiple == true) {
                    $this->setAttrs(array ("multiple" => "multiple", "name" => $this->name . "[]"));
                } else {
                    $this->setAttrs(array ("name" => $this->name));
                }
                if (is_array($this->options)) {
                    $_tmpOptGroup = "";
                    foreach ($this->options as $opt) {
                        $_option = new Typography("option");
                        $_option->setAttrs(array ("value" => $opt->value))
                            ->setText($opt->text);
                        if ($opt->active == true || (is_array($this->defaultOption) && in_array ($opt->value, $this->defaultOption))) {
                            $_option->setAttrs(array("checked" => "checked"));
                        }
                        if ($opt->disabled == true || (is_array($this->disabledOption) && in_array ($opt->value, $this->disabledOption))) {
                            $_option->setAttrs(array ("disabled" => "disabled"));
                        }
                        if (!empty($opt->group)) {
                            if ($_tmpOptGroup != $opt->group) {
                                if (isset ($_optGroup)) {
                                    $this->innerElements [] = $_option;
                                    unset ($_optGroup);
                                }
                                $_optGroup = new Typography("optgroup", null, array ("label" => $opt->group));
                            }
                            $_optGroup->setInnerElements($_option);
                            $_tmpOptGroup = $opt->group;
                        } else {
                            if (isset ($_optGroup)) {
                                $this->innerElements [] = $_optGroup;
                                unset ($_optGroup);
                            }
                            $this->innerElements [] = $_option;
                        }
                        unset ($_option);
                    }
                }
                break;
            case "checkbox":
            case "radio":
                switch ($this->mode) {
                    default:
                    case "regular":
                        if (is_array($this->options) && count ($this->options) > 1) {
                            foreach ($this->options as $opt) {
                                $formCheck = new Typography("div:form-check");
                                if ($this->isStacked == false) $formCheck->setCustomClass(array ("form-check-inline"));
                                $_check = new Input($this->inputType);
                                $_check->setOptions(array($opt)) // only one option will go else below.
                                    ->setName ($this->name . ($this->inputType == "checkbox" ? "[]" : ""));
                                if ($opt->active == true || (is_array($this->defaultOption) && in_array ($opt->value, $this->defaultOption))) {
                                    $_check->setAttrs(array("checked" => "checked"));
                                }
                                if ($opt->disabled == true || (is_array($this->disabledOption) && in_array ($opt->value, $this->disabledOption))) {
                                    $_check->setAttrs(array ("disabled" => "disabled"));
                                }
                                $_checkId = $_check->getId();
                                $_checkLabel = new Typography("label:form-check-label");
                                $_checkLabel->setAttrs(array("for" => $_checkId));
                                $formCheck->setInnerElements(array($_check, $_checkLabel));
                                
                                $this->setInnerElements($formCheck);
                                unset ($formCheck);
                                unset ($_check);
                                unset ($_checkLabel);
                            }
                        } else if ($this->options [0] instanceof Option) {
                            // unable to show label... 
                            $this->setAttrs(array ("type" => $this->inputType, "value" => $this->options [0]->value)) 
                                ->setCustomClass(array ("form-input-check"));
                        }
                    break;
                    case "button":
                        // @todo preserve this style.
                        break;
                    case "onoffswitch":
                        // @todo onoffswitch plugin.
                        break;
                    case "js-switch":
                        // @todo js-switch plugin
                        break;
                } // end of radio/checkbox mode switch
            
                break;
            case "date-picker":
            case "time-picker":
                switch($this->type) {
                    default:
                    case "regular":
                    case "year":
                    case "10year":
                    case "month":
                    case "date-range":
                        // @todo date-picker plugin
                        break;
                    case "time":
                        // @todo time-picker plugin.
                        break;
                        
                }
            default:
        }
        
        parent::render();
        $this->jQuery .= $jQuery;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
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
     * @param string $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        
        return $this;
    }
    
    /**
     * @desc 用在 horizontal 的表單裡，label 和 input 框的比例用
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function getLabelRatio()
    {
        return $this->labelRatio;
    }
    
    /**
     * @desc 用在 horizontal 的表單裡，label 和 input 框的比例用
     * @param Ambigous <unknown, multitype:number > $labelRatio
     */
    public function setLabelRatio($labelRatio)
    {
        $this->labelRatio = $labelRatio;
        
        return $this;
    }
    
    /**
     * @desc for numeric type input, setup a range.
     * @param array $vars
     * @return \model\bootstrap\basic\Input
     *
    function setNumberVars ($vars = array ()) {
        if ($this->inputType == "number") {
            // value:0,min:0,max:200,step:10
            $this->spinnerVars ['max'] = $vars ['max'] ? $vars ['max'] : 200;
            $this->spinnerVars ['min'] = $vars ['min'] ? $vars ['min'] : 0;
            $this->spinnerVars ['step'] = $vars ['step'] ? $vars ['step'] : 1;
        }
        
        return $this;
    }
    */
    
    /**
     * @param array $options
     */
    public function setOptions($options = array ())
    {
        if (!is_array($options)) $option = array ($options);
        if (count($options) > 1) {
            $this->setTagName("div");
            if (!in_array ("form-control", $this->getCustomClass())) $this->setCustomClass("form-control");
        }
        
        for ($i = 0; $i < count($options); $i ++) {
            if (is_array ($options[$i])) {
                $_text      = isset($options[$i] ['text']) ? $options[$i] ['text'] : "";
                $_val       = isset($options[$i] ['value']) ? $options[$i] ['value'] : $_text;
                $_active    = isset($options[$i] ['active']) ? $options[$i] ['active'] : false;
                $_disabled  = isset($options[$i] ['disabled']) ? $options[$i] ['disabled'] : false;
                $_group     = isset($options[$i] ['group']) ? $options[$i] ['group'] : "";
                
                $options[$i] = new Option($_text, $_val, $_active, $_disabled, $_group);
            } else if (!($options[$i] instanceof Option)) {
                $options[$i] = new Option($options[$i]);
            }
        }
        
        $this->options = $options;
        
        return $this;
    }
    
    /**
     * @desc set the default option, allow multiple defaults.
     * @param array $option
     * @return \Bootstrap\basic\Input
     */
    public function setDefaultOption ($option = array ()) {
        if (!is_array($option)) $option = array ($option);
        $this->defaultOption = $option;
        
        return $this;
    }
    
    /**
     *
     * @param array $option
     * @return \Bootstrap\basic\Input
     */
    public function setDisabledOption ($option = array ()) {
        if (!is_array($option)) $option = array ($option);
        $this->disabledOption = $option;
        
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
     *
     * @param unknown $isDisabled
     * @return \Bootstrap\Aceadmin\Input
     */
    public function setIsDisabled($isDisabled = true)
    {
        $this->isDisabled = $isDisabled;
        return $this;
    }

    /**
     * @return the $isDisabled
     */
    public function getIsDisabled()
    {
        return $this->isDisabled;
    }
    
    /**
     * @return the $readonly
     */
    public function getIsReadonly()
    {
        return $this->isReadonly;
    }

    /**
     * @param field_type $readonly
     */
    public function setIsReadonly($readonly = true)
    {
        $this->isReadonly = $readonly;
        
        return $this;
    }

    /**
     *
     * @param string $message
     */
    public function setRequired ($message = "", $isRequired = true) {
        $this->isRequired = $isRequired;
        $this->validation ['required'] = $isRequired;
        $this->validation ['requiredMessage'] = $message ? $message : "請填寫 " . $this->getCaption();
        
        return $this;
    }
    
    /**
     *
     * @param int $length
     * @param string $message
     */
    public function setRequiredMinLength ($length, $message = "") {
        $this->isRequired = true;
        
        $this->validation ['minlength'] = $length;
        $this->validation ['minlengthMessage'] = $message ? $message : "欄位最少長度為 " . $length;
        
        return $this;
    }
    
    /**
     *
     * @param int $length
     * @param string $message
     */
    public function setRequiredMaxLength ($length, $message = "") {
        $this->isRequired = true;
        
        $this->validation ['maxlength'] = $length;
        $this->validation ['maxlengthMessage'] = $message ? $message : "欄位最大長度為 " . $length;
        
        return $this;
    }
    
    /**
     *
     * @param Input $input
     * @param string $message
     */
    public function setRequiredEqualTo (Input $input, $message = "") {
        $this->isRequired = true;
        
        $equalToId = $input->getId();
        if (!$equalToId) {
            // @todo format it.
            $this->setErrMsg("You need an id for required settings.");
        }
        $this->validation ['equalTo'] = '#' . $equalToId;
        $this->validation ['equalToMessage'] = $message ? $message : "與 " . $input->getCaption() . " 內容不相同";
        
        return $this;
    }
    
    /**
     *
     * @param string $message
     * @return \Bootstrap\Aceadmin\Input
     */
    public function setRequiredEmail ($message = "") {
        $this->isRequired = true;
        
        $this->validation ['email'] = true;
        $this->validation ['emailMessage'] = $message ? $message : "必須為 Email 格式";
        
        return $this;
    }
    
    /**
     * @return the $isRequired
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }
    
    /**
     * @return the $validation
     */
    public function getValidation()
    {
        return $this->validation;
    }
    
    /**
     * @return the $dataMask
     *
    public function getDataMask()
    {
        return $this->dataMask;
    }
    
    /**
     * @param field_type $dataMask
     *
    public function setDataMask($dataMask)
    {
        $this->dataMask = $dataMask;
        return $this;
    }
    */
    
    /**
     * @desc 按鈕大小, 可輸入 1~5, 數字愈大按鈕愈大 [xs|sm|lg]
     * @param string $size
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
                //                 $this->size = "miner";
                $this->size = ""; // preserved.
                break;
            case 2:
                $this->size = "xs";
                break;
            case 3:
                $this->size = "sm";
                break;
            case 4:
                $this->size = "";
                break;
            case 5:
                $this->size = "lg";
                break;
            default:
                $this->size = $size;
                
        }
        
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
     * @param Ambigous <string, array> $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return the $isStacked
     */
    public function getIsStacked()
    {
        return $this->isStacked;
    }

    /**
     * @param Ambigous <boolean, array> $isStacked
     */
    public function setIsStacked($isStacked)
    {
        $this->isStacked = $isStacked;
        return $this;
    }
    
    /**
     * @return the $isMultiple
     */
    public function getIsMultiple()
    {
        return $this->isMultiple;
    }

    /**
     * @param field_type $isMultiple
     */
    public function setIsMultiple($isMultiple = true)
    {
        $this->isMultiple = $isMultiple;
        return $this;
    }



}

class Option {
    var $text;
    var $value;
    var $active;
    var $disabled;
    var $group;
    
    public function __construct($text = "", $value = "", $active = false, $disabled = false, $group = "") {
        $this->text = $text;
        $this->value = $value;
        $this->group = $group;
        $this->active = $active;
        $this->disabled = $disabled;
    }
}


