<?php
namespace app\admin\model\bootstrap\hplus;

class InputSlider extends \app\admin\model\bootstrap\basic\InputSlider
{

    protected $handles = array ();
    protected $type; // string [vertical|horizontal]
    protected $range = array (); // array [min, max]
    protected $showScale; // array 
    protected $showTips; // array 
    protected $withInput; // boolean
    
    private $isRequired = false; // boolean
    private $validation = array (); // array
    
    /**
     * @desc generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class = $this->customClass;
        $type = in_array($this->type, array("vertical", "horizontal")) ? $this->type : "";
//         $class [] = "form-control"; 
        
        if ($this->id) { 
            $html = "<div id=\"{$this->id}-slider\"" . (!empty($class) ? " class=\"" . join($class, " ") . "\"" : "");
        } else {
            throw new \Exception("There must be a ID for slider scripts to run.");
        }
        $html .= "></div>";
        
        if ($this->withInput) {
            $inputHtml = "<input class=\"form-control\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->defaultValue}\">";
        } else {
            $inputHtml = "<input class=\"form-control\" type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\" value=\"{$this->defaultValue}\">";
        }
        
        if ($this->labelRatio[1] >= 6) { // 放在同一排，不然就讓他們自己折行
            $html = "<div class=\"row\"><div class=\"col-sm-2\">" . $inputHtml . "</div><div class=\"col-sm-4\">" . $html . "</div></div>\n";            
        } else {
            $html = $inputHtml . $html;
        }
        

        $jQuery = "     
                        var " . str_replace("-", "", $this->id) . "Slider = document.getElementById('{$this->id}-slider');

                        noUiSlider.create(" . str_replace("-", "", $this->id) . "Slider, {
                    	start: [" . join($this->handles, ",") . "],
                    	connect: [true, false],
                    	range: {
                    		'min': {$this->range [0]},
                    		'max': {$this->range [1]}
                    	},
                        format: wNumb({
                            decimals: 0
                        })
                        \n";
        if ($this->showTips) {
            $jQuery .= "
                        ,
                        tooltips: true\n";
        }
        if ($this->showScale) {
            $jQuery .= "
                        ,
                    	pips: { // Show a scale with the slider   \n";
            foreach ($this->showScale as $key => $value) {
                $jQuery .= $key . ": " . (is_string($value) ? "'$value'" : $value) . ",\n";
            }
            $jQuery .= "}\n";
        }
        $jQuery .= "});\n";
        
        if ($this->withInput) {
            $jQuery .= "
                    var " . str_replace("-", "", $this->id) . "InputFormat = document.getElementById('{$this->id}');
                    
                    " . str_replace("-", "", $this->id) . "Slider.noUiSlider.on('update', function( values, handle ) {
                    " . str_replace("-", "", $this->id) . "InputFormat.value = values[handle];
                    });
                    
                    " . str_replace("-", "", $this->id) . "InputFormat.addEventListener('change', function(){
                    " . str_replace("-", "", $this->id) . "Slider.noUiSlider.set(this.value);
                    });
                ";
        }
        
        switch ($this->formType) {
            default:
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
        }
        
        $this->html = $html;
        $this->jQuery = $jQuery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    
    /**
     * @return the $handleLower
     */
    public function getHandleLower()
    {
        return $this->handleLower;
    }

    /**
     * @return the $handleUpper
     */
    public function getHandleUpper()
    {
        return $this->handleUpper;
    }

    /**
     * @param boolean $handleLower
     */
    public function setHandleLower($handleLower)
    {
        $this->handleLower = $handleLower;
        return $this;
    }

    /**
     * @param boolean $handleUpper
     */
    public function setHandleUpper($handleUpper)
    {
        $this->handleUpper = $handleUpper;
        return $this;
    }
    /**
     * @return the $handles
     */
    public function getHandles()
    {
        return $this->handles;
    }

    /**
     * @desc 看有幾個 handle 就設幾個 handle 要在的數字
     * @param multitype: $handles
     */
    public function setHandles($handles = array ())
    {
        if (is_array($handles)) {
            $this->handles = empty($handles) ? array (0) : $handles;
            $this->defaultValue = $handles[0];
        } else  {
            $this->handles = array($handles);
            $this->defaultValue = $handles;
        }
        
        return $this;
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
     * @return the $showScale
     */
    public function getShowScale()
    {
        return $this->showScale;
    }

    /**
     * @return the $showValue
     */
    public function getShowTips()
    {
        return $this->showTips;
    }

    /**
     * @param field_type $showScale
     */
    public function setShowScale($showScale = array ())
    {
        if (empty($showScale)) {
            $showScale = array( "mode"      => 'steps',
                                "stepped"   => true,
                                "density"   => 4);
        }
        $this->showScale = $showScale;
        return $this;
    }

    /**
     * @param field_type $showValue
     */
    public function setShowTips($showValue = true)
    {
        $this->showTips = $showValue;
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
     * @param field_type $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->handles = array ($defaultValue);
        $this->defaultValue = $defaultValue;
        return $this;
    }
    
}




