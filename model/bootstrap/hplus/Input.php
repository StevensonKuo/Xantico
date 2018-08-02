<?php
namespace app\admin\model\bootstrap\hplus;

use think\Exception;

class Input extends \app\admin\model\bootstrap\basic\Input {

    private $isRequired = false;
    private $validation = array ();
    private $dataMask; // string 固定格式
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $jQuery = "";
        if (!$this->caption) $this->caption = $this->text;
        if (!$this->id) $this->id = $this->name;
        
        switch ($this->inputType) {
            case "hidden":
                $html = "<input type=\"hidden\"";
                if ($this->id) $html .= " id=\"{$this->id}\"";
                if ($this->name) $html .= " name=\"{$this->name}\"";
                if ($this->defaultValue) $html .= " value=\"{$this->defaultValue}\"";
                $html .= " />";
                break;
            case "number":
                // H+ 沒有 number 的 input
//                 $html = "<input type=\"text\"";
//                 if ($this->id) $html .= " id=\"{$this->id}\"";
//                 if ($this->name) $html .= " name=\"{$this->name}\"";
//                 if ($this->placeholder) $html .= " placeholder=\"{$this->placeholder}\"";
//                 if ($this->defaultValue) $html .= " value=\"{$this->defaultValue}\"";
//                 $oClass = $this->customClass;
//                 $oClass [] = "spinbox-input";
//                 $oClass [] = "text-center";

//                 $html .= " class=\"" . join(" ", $oClass) . "\" />";
                
//                 $html  = "<div" . ($this->width ? "style=\"width: {$this->width}px;\"" : "") . " class=\"ace-spinner middle\">\n".
//                             "<div class=\"input-group\">" . 
//                             $html . 
//                             "<div class=\"spinbox-buttons input-group-btn btn-group-vertical\">" .
//                             // inside button will be appended by jQuery script.
//                             "</div></div></div>";
                
//                 if (!$this->defaultValue) $this->defaultValue = 0; // number type default.
                
//                 $jQuery = "$('#{$this->id}').ace_spinner({value:{$this->defaultValue},min:{$this->spinnerVars ['min']},max:{$this->spinnerVars ['max']},step:{$this->spinnerVars ['step']}, btn_up_class:'btn-{$this->colorSet}' , btn_down_class:'btn-{$this->colorSet}'})\n" . 
//     				            ".closest('.ace-spinner')\n" . 
//     				            ".on('changed.fu.spinbox', function(){\n".
//     					        "   //alert($('#{$this->id}').val())\n".
//     				            "});\n";
                break;
            case "text":
                $class = $this->customClass;
                if ($this->isStatic) {
                    $class [] = "form-control-static";
                    
                    $html = "<p class=\"" . join(" ", $class) . "\">" . $this->defaultValue . "</p>\n";
                    $html .= "<input type=\"hidden\"";
                    if ($this->id)          $html .= " id=\"{$this->id}\"";
                    if ($this->name)        $html .= " name=\"{$this->name}\"";
                    if ($this->defaultValue)$html .= " value=\"{$this->defaultValue}\"";
                    $html .= " />";
                    
                    if (isset($this->width)) {
                        $html = "<div class=\"col-sm-{$this->width}\">" . $html . "</div>\n";
                    }
                } else {
                    $class [] = "form-control";
                    
                    $html = "<input type=\"text\"";
                    if ($this->id)          $html .= " id=\"{$this->id}\"";
                    if ($this->name)        $html .= " name=\"{$this->name}\"";
                    if ($this->placeholder) $html .= " placeholder=\"{$this->placeholder}\"";
                    if ($this->defaultValue)$html .= " value=\"{$this->defaultValue}\"";
                    if ($this->isDisabled)  $html .= " disabled=\"disabled\"";
                    if ($this->dataMask)    $html .= " data-mask=\"{$this->dataMask}\"";
                    $html .= " class=\"" . join(" ", $class) . "\" />";
                    
                    if (isset($this->width)) {
                        $html = "<div class=\"col-sm-{$this->width}\">" . $html . "</div>\n";
                    }
                }
                
                if ($this->icon) {
                    $this->icon->setAlign($this->iconAlign);
                    $html = "<label class=\"block clearfix\">
                        <span class=\"block input-icon input-icon-{$this->iconAlign}\">\n" .
                        ($this->iconAlign == "right" ? $html . $this->icon : $this->icon . $html) . 
                        "</span></label>\n";
                }
                break;
            case "checkbox":
            case "radio":
                if ($this->options) {
                    $serial = 1;
                    switch ($this->type) {
                        default:
                            foreach ($this->options as $value => $opt) {
                                if (!$this->isStatic) {
                                    $oClass = $this->customClass;
                                    $oClass [] = $this->inputType;
                                    $cbhtml = ($this->display == "block" ? "<div class=\"" . join (" ", $oClass) . "\">\n" : "");
                                    $cbhtml .= "<label class=\"{$this->display}\">";
                                    $iClass = array ();
                                    if ($this->mode != "classic") $iClass [] = "ace";
                                    if ($this->mode == "large") $iClass [] = "input-lg";
                                    $cbhtml .= "<input class=\"" . join (" ", $iClass) .
                                        "\" value=\"$value\" name=\"{$this->name}" .
                                        ($this->inputType == "checkbox" && @count($this->options) > 1 ? "[]" : "") . // checkbox 會是複選
                                        "\" id=\"{$this->id}" . (@count($this->options) > 1 ? "-$serial" : "") . "\" type=\"{$this->inputType}\"";
                                    $cbhtml .= @in_array($value, $this->defaultOption) ? " checked" : "";
                                    $cbhtml .= $this->isDisabled ? " disabled" : "";
                                    $cbhtml .= " />";
                                    $cbhtml .= "<span class=\"lbl\">&nbsp;" . htmlspecialchars($opt) . "</span>" .
                                        "</label>";
                                    $cbhtml .= ($this->display == "block" ? "</div>" : "");
                                    $checkboxes [] = $cbhtml;
                                    
                                    $serial++;
                                    unset ($oClass);
                                    unset ($iClass);
                                } else {
                                    $oClass = $this->customClass;
                                    $cbhtml = ($this->display == "block" ? "<p class=\"" . join (" ", $oClass) . "\">\n" : "");
                                    $badge = new Badge("label");
                                    $badge->setText($opt)
                                        ->setColorSet("default");
                                    if(@in_array($value, $this->defaultOption)) {
                                        $badge->setColorSet("info");
                                    }
                                    $cbhtml .= $badge->render();
                                    $cbhtml .= ($this->display == "block" ? "</p>" : "");
                                    $checkboxes [] = $cbhtml;
                                    
                                    $serial++;
                                    unset ($oClass);
                                    unset ($badge);
                                }
                            }
                            break;
                        case "button":
                            $html = "";
                            if ($this->options) {
                                foreach ($this->options as $value => $opt) {
                                    $oClass = $this->customClass;
                                    $oClass [] = "radio";
                                    $checkboxes [] = "<div class=\"" . join (" ", $oClass) . "\">\n" . 
                                        "<input value=\"$value\" name=\"{$this->name}" . 
                                        ($this->inputType == "checkbox" ? "[]" : "") . // checkbox 會是複選
                                        "\" id=\"{$this->id}-$serial\" type=\"{$this->inputType}\"" . 
                                        (is_array($this->defaultOption) && in_array($value, $this->defaultOption) ? " checked" : "") . 
                                        ($this->isDisabled ? " disabled" : "") . 
                                        "/>\n" . 
                                        ($opt instanceof Icon ? $opt->render () : "<label>$opt</label>\n") . 
                                        "</div>\n";
                                    
                                    $serial++;
                                    unset ($oClass);
                                } 
                            } else {
                                throw new Exception("There is no options for a radio element.");
                            }
                            
                            $html = "<div data-toggle=\"buttons\" class=\"btn-group btn-overlap btn-corner\">" . $html . "</div>";
                            $jQuery .= "
                            	$(document).ready(function(){
                            		$(\"input[name='{$this->name}']\").each(function(){
                            			var self = $(this),
                            			     label = self.next(),
                            			     label_text = label.text();
                            
                            			label.remove();
                            			self.iCheck({
                            				checkboxClass: 'icheckbox_sm-blue',
                            				radioClass: 'radio_sm-blue',
                            				insert: label_text
                            			});
                            		});
                            	});";
                            break;
                        case "onoffswitch":
                            // only one radio element.
                            $value = isset($this->options[0]) ? $this->options[0] : 1;
                            $default = isset($this->defaultOption[0]) ? $this->defaultOption [0] : null;
                            $cbhtml = "
                                <div class=\"switch\">
                                    <div class=\"onoffswitch\">
                                        <input type=\"checkbox\" name=\"{$this->name}\"" . 
                                        ($value == $default ? " checked=\"checked\"" : "") .
                                        ($this->isDisabled == true ? " disabled=\"disabled\"" : "") . 
                                        " class=\"onoffswitch-checkbox\" id=\"{$this->id}\" value=\"$value\">
                                        <label class=\"onoffswitch-label\" for=\"{$this->id}\">
                                            <span class=\"onoffswitch-inner\"></span>
                                            <span class=\"onoffswitch-switch\"></span>
                                        </label>
                                    </div>
                                </div>";
                            $checkboxes [] = $cbhtml;
                            break;
                        case "js-switch":
                            $iClass = $this->customClass;
                            $iClass[] = $this->type;
                            $value = isset($this->options[0]) ? $this->options[0] : 1;
                            $cbhtml = "<input type=\"checkbox\" class=\"" . join (" ", $iClass) .
                                       "\" value=\"$value\" name=\"{$this->name}\"";
                            $cbhtml .= $value == $this->defaultOption ? " checked=\"checked\"" : "";
                            $cbhtml .= $this->isDisabled ? " disabled=\"disabled\"" : "";
                            $cbhtml .= " />";
                            $checkboxes [] = $cbhtml;
                            $jQuery = "
                                    var " . str_replace("-", "", $this->id) . "Elem = document.querySelector('.{$this->type}');
                                    var " . str_replace("-", "", $this->id) . "Init = new Switchery(" . str_replace("-", "", $this->id) . "Elem);
                                    ";
                            /*
                             * Switchery doc. 
                                defaults = {
                                    color             : '#64bd63'
                                  , secondaryColor    : '#dfdfdf'
                                  , jackColor         : '#fff'
                                  , jackSecondaryColor: null
                                  , className         : 'switchery'
                                  , disabled          : false
                                  , disabledOpacity   : 0.5
                                  , speed             : '0.1s'
                                  , size              : 'default'
                                }

                             */
                            break;
                    } 
                }
                
                $html = "<div class=\"form-control-static\">" . join("\n", $checkboxes) . "</div>\n";
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
                        $optionKeys = array_keys($this->options);
                        if (!$this->id) $this->id = "datepicker";
                        $html = "
                            <div class=\"input-daterange input-group\" id=\"{$this->id}\">
                                <span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
                                <input class=\"input-sm form-control\" name=\"{$optionKeys[0]}\" value=\"{$this->options[$optionKeys[0]]}\" type=\"text\">
                                <span class=\"input-group-addon\">到</span>
                                <input class=\"input-sm form-control\" name=\"{$optionKeys[1]}\" value=\"{$this->options[$optionKeys[1]]}\" type=\"text\">
                            </div>";
                        $jQuery .= "
                                $('#{$this->id} input').datepicker({
                                });\n";
                        break;
                    case "time":
                        break;
                    
                }
            default:
        }
        
        switch ($this->formType) {
            default:
            case "form-horizontal":
                $labelHtml = "";
                if ($this->caption) {
                    $labelHtml .= "<label class=\"col-sm-{$this->labelRatio [0]} control-label no-padding-right\" for=\"{$this->id}\">";
                    if ($this->isRequired) { 
                        $labelHtml .= (new Icon("asterisk", array ("colorSet" => "danger")))->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                } else {
                    $this->labelRatio [1] = $this->labelRatio [0] + $this->labelRatio [1];
                }
                
                // input 比格小短的情況
                if (!isset($this->labelRatio [2]) && $this->labelRatio [0] + $this->labelRatio [1] != 12) {
                    $this->labelRatio [2] = $this->labelRatio [1];
                    $this->labelRatio [1] = 12 - $this->labelRatio [0];
                    $html = "<div class=\"form-group\">\n" .
                            $labelHtml . "\n" .
                            "<div class=\"col-sm-{$this->labelRatio [1]}\">\n" . 
                            "<div class=\"row\"><div class=\"col-sm-{$this->labelRatio [2]}\">" . $html . "</div></div>\n".
                            "</div></div>\n";
                } else {
                    $html = "<div class=\"form-group\">\n" .
                            $labelHtml . "\n" .
                            "<div class=\"col-sm-{$this->labelRatio [1]}\">\n" .
                            $html . "</div></div>\n";
                }
                
                break;
            case "form-inline": // 內聯
                $labelHtml = "";
                if ($this->caption) {
                    $labelHtml .= "<label class=\"sr-only\" for=\"{$this->id}\">";
                    if ($this->isRequired) {
                        $labelHtml .= (new Icon("asterisk", array ("colorSet" => "red")))->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                }
                
                $html = "<div class=\"form-group\">\n" .
                    $labelHtml . "\n" .
                    $html . "</div>";
                break;
        }
        
        
        $this->html = $html;
        $this->jQuery .= $jQuery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
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
            throw new \Exception("The equalee field has no ID.");
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
     * input 的子種類
     * hidden:
     * text:
     * button:
     * number:
     * radio/checkbox: {regular|button}
     * date-picker/time-picker: {regular|year|10year|month|date-range|time}
     * @param Ambigous <string, unknown> $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     */
    public function getDataMask()
    {
        return $this->dataMask;
    }

    /**
     * @param field_type $dataMask
     */
    public function setDataMask($dataMask)
    {
        $this->dataMask = $dataMask;
        return $this;
    }


}


