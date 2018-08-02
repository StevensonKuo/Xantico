<?php
namespace app\admin\model\bootstrap\hplus;

class Knob extends \app\admin\model\bootstrap\basic\Input
{

    protected $handles = array ();
    protected $type; // string [vertical|horizontal]
    protected $range = array (); // array [min, max]
    protected $withInput; // boolean
    protected $isMeter; // boolean
    protected $step; // int
    protected $isPointer; // boolean
        
    private $dataAngleArc; // int
    private $dataAngleOffset; // int
    private $isRequired = false; // boolean
    private $validation = array (); // array
    
    /**
     * @desc generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $jQuery = $this->getJQuery();
        $class = $this->customClass;
        if (!$this->width) $this->width = "85";
        switch ($this->colorSet) {
            default:
            case "success":
                $_color = "#1AB394";
                break;
            case "danger":
                $_color = "#ED5565";
        }
        $dataMax = isset($this->range [1]) ? $this->range [1] : 100;
        $dataMin = isset($this->range [0]) ? $this->range [0] : 0;
        if ($this->id) {
            $html = "<div class=\"inline\">
                        <input type=\"text\" value=\"{$this->defaultValue}\" class=\"dial\" data-fgColor=\"{$_color}\" data-width=\"{$this->width}\" data-height=\"{$this->width}\" data-min=\"{$dataMin}\" data-max=\"{$dataMax}\" id=\"{$this->id}\"".($this->isMeter ? " data-angleoffset=\"-125\" data-anglearc=\"250\"" : "")." />
                    </div>";
        } else {
            throw new \Exception("There must be a ID for Knob scripts to run.");
        }
        
        
/*         if ($this->withInput) {
            $inputHtml = "<input class=\"form-control\" name=\"{$this->name}\" id=\"{$this->id}\">";
        } else {
            $inputHtml = "<input class=\"form-control\" type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\">";
        }
 */        
        $jQuery .= "
            $(function() {
                $('.dial').knob();
            });
        ";
        $labelHtml = "";
        switch ($this->formType) {
            case "form-horizontal":
                if ($this->caption) {
                    $labelHtml = "<label class=\"col-sm-{$this->labelRatio [0]} control-label no-padding-right\" for=\"{$this->id}\">{$this->caption}</label>";
                } else {
                    $labelHtml = "";
                    $this->labelRatio [1] = $this->labelRatio [1] + $this->labelRatio [0];
                }
                
                $html = "<div class=\"form-group\">\n".
                        $labelHtml . "\n" .
                        "<div class=\"col-sm-{$this->labelRatio [1]}\">" . $html . "</div></div>";
                break;
            case "form-inline":
                if ($this->caption) {
                    $labelHtml .= "<label class=\"sr-only\" for=\"{$this->id}\">{$this->caption}</label>";
                }
                $html = "<div class=\"form-group\">\n".
                    $labelHtml . "\n" .
                    $html . "</div>";
                break;
            default:
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
     * @return the $range
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @desc slider 的最大最小值
     * @param multitype: $range
     */
    public function setRange($range = array (0, 100))
    {
        $this->range = empty($range) ? array (0, 100) : $range;
        return $this;
    }


    /**
     * @return the $withInput
     */
    public function getWithInput()
    {
        return $this->withInput;
    }

    /**
     * @param field_type $withInput
     */
    public function setWithInput($withInput = true)
    {
        $this->withInput = $withInput;
        return $this;
    }
    /**
     * @return the $isMeter
     */
    public function getIsMeter()
    {
        return $this->isMeter;
    }

    /**
     * @param field_type $isMeter
     */
    public function setIsMeter($isMeter = true)
    {
        $this->isMeter = $isMeter;
        return $this;
    }

    
}




