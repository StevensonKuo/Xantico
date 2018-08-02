<?php
namespace app\admin\model\bootstrap\hplus;

class Textarea extends \app\admin\model\bootstrap\basic\Textarea
{

    private $isRequired = false; // boolean
    private $validation = array (); // array
    
    /**
     * @desc generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class = $this->customClass;
        
        if ($this->isStatic) {
            $class [] = "form-control-static";
            $html = "<p";
            $html .= " class=\"" . join(" ", $class) . "\">";
            $html .= htmlspecialchars($this->text) . "</p>\n";
            $html .= "<input type=\"hidden\"";
            if ($this->id)          $html .= " id=\"{$this->id}\"";
            if ($this->name)        $html .= " name=\"{$this->name}\"";
            if ($this->text)        $html .= " value=\"{$this->text}\"";
            $html .= " />";
        } else {
            $class [] = "form-control";
            $html = "<textarea";
            if ($this->id)          $html .= " id=\"{$this->id}\"";
            if ($this->name)        $html .= " name=\"{$this->name}\"";
            if ($this->rows)        $html .= " rows=\"{$this->rows}\"";
            if ($this->cols)        $html .= " cols=\"{$this->cols}\"";
            if ($this->isDisabled)  $html .= " disabled=\"disabled\"";
            if ($this->placeholder) $html .= " placeholder=\"{$this->placeholder}\"";
            if ($this->maxlength) {
                $class [] = "limited";
                $html .= " maxlength=\"{$this->maxlength}\"";
            }
            
            $html .= " class=\"" . join(" ", $class) . "\">";
            $html .= htmlspecialchars($this->text) . "</textarea>";
            
        }
        
        switch ($this->formType) {
            default:
            case "horizontal":
                if ($this->caption) {
                    $labelHtml = "<label class=\"col-sm-{$this->labelRatio [0]} control-label no-padding-right\" for=\"{$this->id}\">";
                    if ($this->isRequired) {
                        $labelHtml .= (new Icon("asterisk", array ("colorSet" => "danger")))->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                } else {
                    $labelHtml = "";
                    $this->labelRatio [1] = $this->labelRatio [1] + $this->labelRatio [0];
                }
                
                $html = "<div class=\"form-group\"" . (!empty($this->customStyle) ? " style=\"".join(", ", $this->customStyle)."\"" : "") . ">\n".
                        $labelHtml . "\n" .
                        "<div class=\"col-sm-{$this->labelRatio [1]}\">" . $html . "</div></div>";
                break;
            case "inline":
                if ($this->caption) {
                    $labelHtml = "<label class=\"sr-only\" for=\"{$this->id}\">";
                    if ($this->isRequired) {
                        $labelHtml .= (new Icon("asterisk", array ("colorSet" => "red")))->render () . "&nbsp;";
                    }
                    $labelHtml .= $this->caption . "</label>";
                }
                
                $html = "<div class=\"form-group\"" . (!empty($this->customStyle) ? " style=\"".join(", ", $this->customStyle)."\"" : "") . ">\n".
                        $labelHtml . "\n" .
                        $html . "</div>";
                break;
        }
        
        $this->html = $html;
        
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
        $this->validation ['requiredMessage'] = $message ? $message : "請填寫 " . $this->caption;
        
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
    
}




