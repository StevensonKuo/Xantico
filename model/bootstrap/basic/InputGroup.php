<?php
namespace model\bootstrap\basic;

class InputGroup extends Typography
{
 
    protected $leftAddon; // icon, text ,button or an array of them.
    protected $rightAddon; // ...  
    protected $inputBody; // Input
    protected $help; // string, small text bellow the input field.
    

    /**
     * @desc @todo will crash when inner input has validation message.
     * @param array $vars
     * @param array $attr
     */
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
        
        if (!empty($this->leftAddon) && is_array($this->leftAddon)) {
            if ($this->leftAddon[0] instanceof Button || $this->leftAddon[0] instanceof Dropdown) {
                $inputGroupAddon = new Typography("span:input-group-btn");
            } else { // icon, string, other inputs
                $inputGroupAddon = new Typography("span:input-group-addon");
            }
            $inputGroupAddon->setInnerElements($this->leftAddon);
            $_elements [] = $inputGroupAddon;
        }
        
        if (!empty($this->inputBody)) {
            $_elements [] = $this->inputBody;
            // put other inner element in below.
        }
        if (!empty($this->innerElements)) {
            // It's too late to assign inner element attribute to $this here.
            $_elements = array_merge($_elements, $this->innerElements);
        }
        
        if (!empty($this->rightAddon) && is_array($this->rightAddon)) {
            if ($this->rightAddon [0] instanceof Button || $this->rightAddon [0] instanceof Dropdown) {
                $inputGroupAddon = new Typography("span:input-group-btn");
            } else { // icon, string, other inputs
                $inputGroupAddon = new Typography("span:input-group-addon");
            }
            $inputGroupAddon->setInnerElements($this->rightAddon);
            $_elements [] = $inputGroupAddon;
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
     * @return the $inputBody
     */
    public function getInputBody()
    {
        return $this->inputBody;
    }

    /**
     * @param field_type $inputBody
     */
    public function setInputBody(Input $inputBody)
    {
        if (method_exists($inputBody, "getCaption") && !empty($inputBody->getCaption()) && empty($this->caption)) {
            $this->caption = $inputBody->getCaption();
        }
        if (method_exists($inputBody, "getHelp") && !empty($inputBody->getHelp()) && empty($this->help)) {
            $this->help = $inputBody->getHelp();
        }
        
        $this->inputBody = $inputBody;
        
        return $this;
    }

    
}
