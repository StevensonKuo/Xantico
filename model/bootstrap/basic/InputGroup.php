<?php
namespace model\bootstrap\basic;

use bootstrap\basic\iRequiredInput;

class InputGroup extends Typography implements iRequiredInput 
{
 
    protected $leftAddon; // icon, text ,button or an array of them.
    protected $rightAddon; //
    protected $help; // string, small text bellow the input field.
    protected $isRequired;
    protected $validation;
    
    
    public function __construct($vars = array (), $attr = array())
    {
        parent::__construct("div:input-group", $vars, $attr);
        
        $this->leftAddon    = isset ($vars ['leftAddon']) ? $vars ['leftAddon'] : false;
        $this->rightAddon   = isset ($vars ['rightAddon']) ? $vars ['rightAddon'] : false;
        $this->isRequired   = isset($vars ['isRequired']) ? $vars ['isRequired'] : false;
        $this->validation   = isset($vars ['validation']) ? $vars ['validation'] : array ();
    }
    
    /**
     * @desc left addon + original inner elements + right addon = new inner elements.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        
        if (!empty($this->size)) {
            $this->setCustomClass("input-group-" . $this->size);
        }
        
        $_elements = array ();
        
        if (!empty($this->leftAddon)) {
            foreach ($this->leftAddon as $left) {
                if ($left instanceof Button || $left instanceof Dropdown) {
                    if (!isset ($inputGroupBtn)) {
                        $inputGroupBtn = new Typography("span:input-group-btn");
                    }
                    $inputGroupBtn->setInnerElements($left);
                } else { // icon, string, other inputs
                    if (!isset($inputGroupAddon)) {
                        $inputGroupAddon = new Typography("span:input-group-addon");
                    }
                    $inputGroupAddon->setInnerElements($left);
                }
            }
            if (isset ($inputGroupBtn)) {
                $_elements [] = $inputGroupBtn;
            }
            if (isset($inputGroupAddon)) {
                $_elements [] = $inputGroupAddon;
            }
        }
        
        $_elements = array_merge($_elements, $this->innerElements);
        
        if (!empty($this->rightAddon)) {
            foreach ($this->rightAddon as $right) {
                if ($right instanceof Button || $right instanceof Dropdown) {
                    if (!isset ($inputGroupBtn)) {
                        $inputGroupBtn = new Typography("span:input-group-btn");
                    }
                    $inputGroupBtn->setInnerElements($right);
                } else { // icon, string, other inputs
                    if (!isset($inputGroupAddon)) {
                        $inputGroupAddon = new Typography("span:input-group-addon");
                    }
                    $inputGroupAddon->setInnerElements($right);
                }
            }
            if (isset ($inputGroupBtn)) {
                $_elements [] = $inputGroupBtn;
            }
            if (isset($inputGroupAddon)) {
                $_elements [] = $inputGroupAddon;
            }
        }
        
        $this->innerElements = $_elements;
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc input group size, same as something like button. [xs|sm|lg]
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setSize()
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
     * @return the $leftAddon
     */
    public function getLeftAddon()
    {
        return $this->leftAddon;
    }

    /**
     * @return the $rightAddon
     */
    public function getRightAddon()
    {
        return $this->rightAddon;
    }

    /**
     * @param Ambigous <boolean, array> $leftAddon
     */
    public function setLeftAddon($leftAddon)
    {
        if (!is_array ($leftAddon)) $leftAddon = array ($leftAddon);
        $this->leftAddon = $leftAddon;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $rightAddon
     */
    public function setRightAddon($rightAddon)
    {
        if(!is_array($rightAddon)) $rightAddon = array ($rightAddon);
        $this->rightAddon = $rightAddon;
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
     *
     * @param string $message
     */
    public function setIsRequired ($message = "", $isRequired = true) {
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
    public function setRequiredEqualTo (Typography $input, $message = "") {
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
     * @param Ambigous <multitype:, array> $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
        return $this;
    }
    
}
