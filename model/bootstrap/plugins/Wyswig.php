<?php
namespace app\admin\model\bootstrap\hplus;

class Wyswig extends \app\admin\model\bootstrap\basic\Wyswig
{

    private $isRequired = false; // boolean
    private $validation = array (); // array
    private $withInput; // boolean
    
    function __construct($type = "summernote", $config = array ()) {
        $this->withInput = true;
        $this->type = $type;
        
        parent::__construct($type, $config);
        return $this;
    }
    
    /**
     * @desc generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $class = $this->customClass;
        
        $html = "
            <div class=\"summernote\">
                {$this->text}
            </div>
        ";
        if ($this->withInput) {
            $html .= "<input type=\"hidden\" name=\"{$this->name}\" id=\"{$this->id}\"/>\n";
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
                
                $html = "<div class=\"form-group\">\n".
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
                
                $html = "<div class=\"form-group\">\n".
                        $labelHtml . "\n" .
                        $html . "</div>";
                break;
        }
        
        $jquery = "";
        if (!$this->isStatic) { // 靜態的話就不把 wyswig 編輯器叫出來
            $jquery .= "
                $(document).ready(function () {
                    $('.summernote').summernote({
                        lang: 'zh-CN'
                    });
                
                });
            ";
        }
        if ($this->withInput) {
            $jquery .= "
                $('form[name=create_coupon]').on('submit', function () {
                    var aHTML = $('.summernote').code();
                    $('#coupon_richtext').val(aHTML);
                });
            ";                
        }
        
        
        $this->html = $html;
        $this->jQuery .= $jquery;
        
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
    
    /**
     * @desc 目前只有 summernote
     * @desc http://hackerwins.github.io/summernote/features.html#api
     * @param string $type
     * @return \app\admin\model\bootstrap\hplus\Wyswig
     */
    public function setType ($type = "summernote") {
        $this->type = $type;
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
     * @desc 是否有 input 欄位一同 submit 出去
     * @param boolean $withInput
     */
    public function setWithInput($withInput = true)
    {
        $this->withInput = $withInput;
        return $this;
    }

    
}




