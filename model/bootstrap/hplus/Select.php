<?php
namespace app\admin\model\bootstrap\hplus;

class Select extends \app\admin\model\bootstrap\basic\Select {
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class [] = "form-control";
        
        $html = "<select class=\"" . join (" ", $class) . "\"";
        if ($this->id)  $html .= " id=\"{$this->id}\"";
        if ($this->name)  $html .= " name=\"{$this->name}\"";
        $html .= " />";
        
        if ($this->width) {
            $html = "<div class=\"col-sm-{$this->width}\">" . $html . "</div>\n";
        }
            
        if ($this->options) {
            $optionHtml = "";
            foreach ($this->options as $value => $opt) {
                $optionHtml .= "<option value=\"$value\"" . ($this->defaultOption == $value ? " selected" : "") . 
                                ">". htmlspecialchars($opt) . "</option>\n";
            }
        }
        
        $html = $html . $optionHtml . "</select>";
        $labelHtml = "";
        switch ($this->formType) {
            default:
            case "form-inline":
                $labelHtml .= "<label class=\"sr-only\" for=\"{$this->id}\">{$this->text}</label>";
                $html = "<div class=\"form-group\">\n".
                    $labelHtml . "\n" .
                    $html . "</div>";
                break;
            case "form-horizontal":
                $labelHtml .= "<label class=\"col-sm-{$this->labelRatio [0]} control-label no-padding-right\" for=\"{$this->id}\">{$this->text}</label>";
                $html = "<div class=\"form-group\">\n".
                    $labelHtml . "\n" .
                    "<div class=\"col-sm-{$this->labelRatio [1]}\">" . $html . "</div></div>";
                break;
        }
        
        $this->html = $html;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    

}



