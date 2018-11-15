<?php
namespace model\bootstrap\basic;

use bootstrap\basic\iRequiredInput;
use model\bootstrap\HtmlTag;

class Input extends Typography implements iRequiredInput {
    protected $inputType; // enum [text|hidden|radio|checkbox|number]
    protected $name; // string
    protected $placeholder; // string
    protected $defaultValue; // string
    protected $labelRatio; // array
    protected $textContext; // label text color set.
    protected $help; // string, small text bellow the input field.
    protected $isDisabled; // boolean
    protected $isReadonly; // boolean
    protected $isStatic; // boolean; preserved
    protected $options; // array; for checkbox and radio.
    protected $defaultOption = array (); // array|int|string for radio and checkbox.
    protected $disabledOption = array (); // array|int|string for radio and checkbox.
    protected $isStacked; // boolean, for radios and checkboxes.
    protected $isMultiple; // boolean, for select
    protected $isRequired;
    protected $isFormControl; // string, add form-control class
    protected $validationState; // string
    protected $hasFeedback; // boolean
    protected $validation;
    
    //     protected $spinnerVars; // for number type.
    //     protected $isStatic; //
    //     protected $dataMask; // string
    
    private static $inputTypeArr = array (
        "text", "email", "password", "hidden", "radio", "checkbox", "file",  
        "select", "button", "submit", "reset", "textarea", "number"
    );
    // html5 input type: text, password, datetime, datetime-local, date, month, time, week, number, email, url, search, tel, and color.
    private static $formValidationSourceArr = array (
        "jquery", 
        "browser" 
    );
    
    protected static $validationStateArr = array (
        "success", "warning", "error" 
    );
    
    public static $AUTO_NAMING = false;
    public static $FORM_VALIDATION_METHOD = "jquery";
    
    /**
     * @param string $inputType
     * @param array $vars
     * @return \model\bootstrap\basic\Input
     */
    public function __construct($inputType = "text", $vars = array (), $attr = array ())
    {
        $inputType = trim(strtolower($inputType));
        $this->inputType = !empty($inputType) && in_array($inputType, self::$inputTypeArr) ? $inputType : "text";
        if ($this->inputType == "textarea" || $this->inputType == "select") {
            parent::__construct($this->inputType, $vars, $attr);
        } else { // text etc.
            parent::__construct("input", $vars, $attr);
        }
        
//         if ($this->inputType == "hidden") $this->type = "hidden"; // @todo ?why
        $this->placeholder      = isset($vars ['placeholder']) ? $vars ['placeholder'] : "";
        $this->name             = isset($vars ['name']) ? $vars ['name'] : "";
        $this->textContext      = isset($vars ['textContext']) ? $vars ['textContext'] : "";
        $this->defaultValue     = isset($vars ['defaultValue']) ? $vars ['defaultValue'] : ($this->inputType != "number" ? "" : "0");
        $this->labelRatio       = isset($vars ['labelRatio']) ? $vars ['labelRatio'] : array (3, 9); // 字寬３欄寬９
        $this->options          = isset($vars ['options']) ? $vars ['options'] : array ();
        $this->defaultOption    = isset($vars ['defaultOption']) ? $vars ['defaultOption'] : null;
        $this->disabledOption   = isset($vars ['disabledOption']) ? $vars ['disabledOption'] : null;
        $this->isDisabled       = isset($vars ['isDisabled']) ? $vars ['isDisabled'] : false;
        $this->isReadonly       = isset($vars ['isReadonly']) ? $vars ['isReadonly'] : false;
        $this->isStatic         = isset($vars ['isStatic']) ? $vars ['isStatic'] : false;
        $this->isStacked        = isset($vars ['isStacked']) ? $vars ['isStacked'] : true;
        $this->isMultiple       = isset($vars ['isMultiple']) ? $vars ['isMultiple'] : false;
//         $this->spinnerVars  = array ("min" => 0, "max" => 999999999, "step" => 1);
        $this->isRequired       = isset($vars ['isRequired']) ? $vars ['isRequired'] : false;
        $this->isFormControl    = isset($vars ['isFormControl']) ? $vars ['isFormControl'] : true;
        $this->validation       = isset($vars ['validation']) ? $vars ['validation'] : array ();
        $this->hasFeedback      = isset($vars ['hasFeedback']) ? $vars ['hasFeedback'] : false;
        $this->validationState  = isset($vars ['validationState']) ? $vars ['validationState'] : null;
        $this->screw        = array (
            "text"      => "&nbsp;",
            "value"     => "",
            "active"    => false,
            "disabled"  => false,
            "group"     => null 
        );
        
    }
    
    /**
     * @param string $display
     * @return unknown
     */
    public function render($display = false)
    {
        $jQuery = "";
        if (!$this->caption) $this->caption = $this->innerText;
        if (self::$AUTO_NAMING == true AND empty($this->name)) { // auto naming.
            if (empty($this->id)) $this->setId();
            $this->name = $this->id;
        }
        
        switch ($this->inputType) {
            case "hidden":
                $this->appendAttrs(array ("type" => $this->inputType));
                if (!empty($this->defaultValue)) $this->attrs ["value"] = $this->defaultValue;
                break;
            case "number":
                // @todo preserved. 
                break;
            case "password":
            case "email": // This one might be from html5.
            case "button":
            case "reset":
            case "submit":
            case "file":
            case "text":
                $this->attrs ["type"] = $this->inputType;
                if (!empty($this->placeholder)) $this->attrs ["placeholder"] = $this->placeholder;
                if (!empty($this->name)) $this->attrs ["name"] = $this->name;
                if (!empty($this->defaultValue)) $this->attrs ['value'] = $this->defaultValue;
                if ($this->isRequired == true && self::$FORM_VALIDATION_METHOD == "browser") $this->attrs ['required'] = "required"; 
//                 if (!empty($this->size)) $_class [] = "form-control-" . $this->size; // bs 4.0
                if ($this->isDisabled == true) $this->attrs ["disabled"] = "disabled";
                if ($this->isReadonly == true) $this->attrs ["readonly"] = "readonly";
                if ($this->isStatic == true) {
                    /* bs 4.0
                     $_class [] = "form-control-plaintext";
                     $this->attrs ["readonly"] = "readonly";
                     */
                    $this->setTagName("p");
                    $this->attrs = array ();
                    if ($this->isFormControl == true) {
                        $this->customClass [] = "form-control";
                    }
                    
                    $this->innerText = $this->defaultValue;
                } else if ($this->isFormControl == true) {
                    $this->customClass [] = "form-control" . ($this->inputType == "file" ? "-file" : "");
                }
                
                break;
            case "textarea":
                if (false) {
                // if ($this->isStatic) {
                    // @todo static output
                    // bootstrap 4.0 add form-control-plaintext to class. (and both readonly)
                } else {
                    if (!empty($this->placeholder)) $this->attrs ["placeholder"] = $this->placeholder;
                    if (!empty($this->defaultValue)) $this->innerText = $this->defaultValue; // @todo what will happen if value contains html tag???
                    if (!empty($this->isDisabled)) $this->attrs ["disabled"] = "disabled";
                    if (!empty($this->isReadonly)) $this->attrs ["readonly"] = "readonly";
                    if ($this->isFormControl == true) {
                        $this->customClass [] = "form-control";
                        if (!empty($this->size)) {
                            $this->customClass [] = "form-control-" . $this->size;
                        }
                    }
                    if ($this->isRequired == true && self::$FORM_VALIDATION_METHOD == "browser") $this->attrs ['required'] = "required";
                }
                
                break;
            case "select":
                if ($this->isFormControl == true) $this->customClass [] = "form-control";
                if ($this->isMultiple == true) $this->attrs ["multiple"] = "multiple"; 
                if (!empty($this->name)) $this->attrs ["name"] = $this->name . ($this->isMultiple == true ? "[]" : "");
                if ($this->isRequired == true && self::$FORM_VALIDATION_METHOD == "browser") $this->attrs ['required'] = "required";
                if (is_array($this->options) && !empty($this->options)) {
                    $_tmpOptGroup = "";
                    foreach ($this->options as $opt) {
                        $_option = new Typography("option");
                        $_option->appendAttrs(array ("value" => $opt ['value']))
                        ->setText($opt ['text']);
                        if ($opt ['active'] == true || (is_array($this->defaultOption) && in_array ($opt ['value'], $this->defaultOption))) {
                            $_option->appendAttrs(array("selected" => "selected"));
                        }
                        if ($opt ['disabled'] == true || (is_array($this->disabledOption) && in_array ($opt ['value'], $this->disabledOption))) {
                            $_option->appendAttrs(array ("disabled" => "disabled"));
                        }
                        if (!empty($opt ['group'])) {
                            if ($_tmpOptGroup != $opt ['group']) {
                                if (isset ($_optGroup)) {
                                    $this->innerElements [] = $_option;
                                    unset ($_optGroup);
                                }
                                $_optGroup = new Typography("optgroup", null, array ("label" => $opt ['group']));
                            }
                            $_optGroup->appendInnerElements($_option);
                            $_tmpOptGroup = $opt ['group'];
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
                        if (!empty($this->options)) {
                            $this->setTagName("div");
                            if ($this->isStacked == false) {
                                $this->appendCustomClass($this->inputType);
                            }
                            
                            foreach ($this->options as $opt) {
                                if ($this->isStacked == true) {
                                    $_checkDiv = new HtmlTag("div");
                                    $_checkDiv->setCustomClass($this->inputType);
                                }
                                
                                $_check = new Input($this->inputType);
//                                 $_check->appendCustomClass($this->getCustomClass());
                                $_check->appendAttrs($this->getAttrs());
                                $_check->setDefaultValue($opt ['value']);
                                $_check->setIsRequired($this->getIsRequired())->setValidation($this->getValidation());
                                if (!empty($this->name)) {
                                    $_check->setName($this->name . ($this->inputType == "checkbox" ? "[]" : ""));
                                }
                                if ($opt ['active'] == true || (is_array($this->defaultOption) && in_array ($opt ['value'], $this->defaultOption))) {
                                    $_check->appendAttrs(array ("checked" => "checked"));
                                }
                                if ($opt ['disabled'] == true || (is_array($this->disabledOption) && in_array ($opt ['value'], $this->disabledOption))) {
                                    $_check->appendAttrs(array ("disabled" => "disabled"));
                                    if ($this->isStacked == true && isset ($_checkDiv)) $_checkDiv->appendCustomClass("disabled");
//                                     else $this->appendCustomClass("disabled");
                                }
                                if ($this->isRequired == true && self::$FORM_VALIDATION_METHOD == "browser") {
                                    $_check->appendAttrs (array('required' => "required"));
                                }
                                $_checkLabel = new HtmlTag("label");
                                $_checkLabel->setInnerElements(array($_check, "&nbsp;" . $opt ['text']));
                                if ($this->isStacked == false) $_checkLabel->appendCustomClass(array ($this->inputType."-inline"));
                                
                                if ($this->isStacked == true && isset ($_checkDiv)) {
                                    $_checkDiv->appendInnerElements($_checkLabel);
                                    $this->appendInnerElements($_checkDiv);
                                    unset($_checkDiv);
                                } else {
                                    $this->appendInnerElements($_checkLabel);
                                }
                                unset ($_check);
                                unset ($_checkLabel);
                            }
                        } else {
                            // unable to show label...
                            $this->attrs ["type"] = $this->inputType;
                            $this->defaultValue = $this->defaultValue . "";
                            if (strlen($this->defaultValue) > 0) $this->attrs ['value'] = $this->defaultValue;
                            if (!empty($this->name)) $this->attrs ['name'] = $this->name;
//                             $this->customClass [] = "form-check-input";
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
                switch($this->mode) {
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
        $this->jQuery .= (!empty($this->jQuery) ? $this->jQuery . "\n" : "") . $jQuery;
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
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
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
        
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
        if (is_array ($labelRatio)) {
            $this->labelRatio = $labelRatio;
        } else {
            $this->labelRatio = explode(":", $labelRatio);
        }
        
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
        if (!empty($options)) {
            $_options = array ();
            foreach ($options as $value => $optText) {
                if (is_array ($optText)) {
                    $_newOpt ['text']       = isset($optText ['text']) ? $optText ['text'] : $this->screw ['text'];
                    $_newOpt ['value']      = isset($optText ['value']) ? $optText ['value'] : $value;
                    $_newOpt ['active']     = isset($optText ['active']) ? $optText ['active'] : $this->screw ['active'];
                    $_newOpt ['disabled']   = isset($optText ['disabled']) ? $optText ['disabled'] : $this->screw ['disabled'];
                    $_newOpt ['group']      = isset($optText ['group']) ? $optText ['group'] : $this->screw ['group'];
                } else {
                    $_newOpt ['text']     = $optText;
                    $_newOpt ['value']    = $value;
                    $_newOpt ['active']   = $this->screw ['active'];
                    $_newOpt ['disabled'] = $this->screw ['disabled'];
                    $_newOpt ['group']    = $this->screw ['group'];
                }
                $_options [] = $_newOpt;
                unset ($_newOpt);
            }
        }
        
        $this->options = $_options;
        
        return $this;
    }
    
    /**
     * @param array $options
     */
    public function appendOptions($options = array ())
    {
        $options = array_merge($this->options, $options);
        
        $this->setOptions($options);
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
     * @param Ambigous <string, unknown> $textContext
     */
    public function setTextContext($textContext)
    {
        $this->textContext = $textContext;
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
    public function setIsRequired ($message = "", $isRequired = true) {
        $this->isRequired = $isRequired;
        $this->validation ['required'] = $isRequired;
        $this->validation ['requiredMessage'] = $message ? $message : iRequiredInput::INPUT_REQUIRED_DEFAULT;
        
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
        $this->validation ['minlengthMessage'] = $message ? $message : iRequiredInput::INPUT_REQUIRED_MINLENGTH . $length;
        
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
        $this->validation ['maxlengthMessage'] = $message ? $message : iRequiredInput::INPUT_REQUIRED_MAXLENGTH . $length;
        
        return $this;
    }
    
    /**
     *
     * @param Input $input
     * @param string $message
     */
    public function setRequiredEqualTo (Typography $input, $message = "") {
        $this->isRequired = true;
        
        if (empty($input->getId())) {
            $this->setErrMsg("[Notice] You need an id for required settings and ID is auto-generated.");
            $input->setId();
        }
        $equalToId = $input->getId();
        $this->validation ['equalTo'] = '#' . $equalToId;
        $this->validation ['equalToMessage'] = $message ? $message : iRequiredInput::INPUT_REQUIRED_EQUALTO . $input->getCaption();
        
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
        $this->validation ['emailMessage'] = $message ? $message : iRequiredInput::INPUT_REQUIRED_EMAIL;
        
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

    /**
     * @return the $help
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * @param field_type $help
     */
    public function setHelp($help)
    {
        $this->help = $help;
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
     * @param Ambigous <boolean, array> $isStatic
     */
    public function setIsStatic($isStatic = true)
    {
        $this->isStatic = $isStatic;
        return $this;
    }
    
    /**
     * @param Ambigous <multitype:, array> $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
        return $this;
    }
    
    /**
     * @return the $inputType
     */
    public function getInputType()
    {
        return $this->inputType;
    }

    /**
     * @param string $inputType
     */
    public function setInputType($inputType)
    {
        $inputType = strtolower($inputType);
        if (in_array($inputType, self::$inputTypeArr)) {
            $this->inputType = $inputType;
            
            if ($inputType == "select" || $inputType == "textarea") {
                $this->setTagName($inputType);
            }
        }
        
        return $this;
    }
    
    public function setInputTypeText() {
        $this->inputType = "text";
        return $this;
    }

    public function setInputTypePassword() {
        $this->inputType = "password";
        return $this;
    }

    public function setInputTypeEmail() {
        $this->inputType = "email";
        return $this;
    }

    
    public function setInputTypeHidden() {
        $this->inputType = "hidden";
        return $this;
    }

    public function setInputTypeRadio() {
        $this->inputType = "radio";
        return $this;
    }

    public function setInputTypeCheckbox() {
        $this->inputType = "checkbox";
        return $this;
    }

    public function setInputTypeFile() {
        $this->inputType = "file";
        return $this;
    }

    public function setInputTypeSelect() {
        $this->inputType = "select";
        $this->setTagName("select");
        return $this;
    }

    public function setInputTypeButton() {
        $this->inputType = "button";
        return $this;
    }

    public function setInputTypeSubmit() {
        $this->inputType = "submit";
        return $this;
    }

    public function setInputTypeReset() {
        $this->inputType = "reset";
        return $this;
    }

    public function setInputTypeTextarea() {
        $this->inputType = "textarea";
        $this->setTagName("textarea");
        return $this;
    }

    public function setInputTypeNumber() {
        $this->inputType = "number";
        return $this;
    }
    
    /**
     * @return the $validationState
     */
    public function getValidationState()
    {
        return $this->validationState;
    }

    /**
     * @param field_type $validationState
     */
    public function setValidationState($validationState)
    {
        $validationState = strtolower($validationState);
        if (in_array($validationState, self::$validationStateArr)) {
            $this->validationState = $validationState;
            if ($this->inputType == "text") $this->hasFeedback = true;
        }
        return $this;
    }
    
    public function setValidationStateSuccess () {
        $this->validationState = "success";
        if ($this->inputType == "text") $this->hasFeedback = true;
        return $this;
    }

    public function setValidationStateWarning () {
        $this->validationState = "warning";
        if ($this->inputType == "text") $this->hasFeedback = true;
        
        return $this;
    }
    
    public function setValidationStateError () {
        $this->validationState = "error";
        if ($this->inputType == "text") $this->hasFeedback = true;
        
        return $this;
    }
    
    public function setValidationStateDanger () {
        $this->validationState = "error";
        if ($this->inputType == "text") $this->hasFeedback = true;
        
        $this->setErrMsg("[Notice] There is only error state for validation. no danger state.");
        return $this;
    }
    
    /**
     * @return the $hasFeedback
     */
    public function getHasFeedback()
    {
        return $this->hasFeedback;
    }

    /**
     * @param field_type $hasFeedback
     */
    public function setHasFeedback($hasFeedback = true)
    {
        if ($this->inputType == "text") {
            $this->hasFeedback = $hasFeedback;
        }
        
        return $this;
    }
    
    /**
     * @return the $isFormControl
     */
    public function getIsFormControl()
    {
        return $this->isFormControl;
    }

    /**
     * @param Ambigous <boolean, array> $isFormControl
     */
    public function setIsFormControl($isFormControl = false)
    {
        $this->isFormControl = $isFormControl;
        return $this;
    }


    
}



