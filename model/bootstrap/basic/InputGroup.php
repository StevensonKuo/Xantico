<?php
namespace model\bootstrap\basic;

class InputGroup extends Typography 
{
 
    protected $leftAddon; // icon, text ,button or an array of them.
    protected $rightAddon; // 
    
    public function __construct($vars = array (), $attr = array())
    {
        parent::__construct("div:btn-group", $vars, $attr);
        
        $this->leftAddon    = isset ($vars ['leftAddon']) ? $vars ['leftAddon'] : false;
        $this->rightAddon    = isset ($vars ['rightAddon']) ? $vars ['rightAddon'] : false;
        
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
                        $inputGroupBtn = new Typography("div:input-group-btn");
                    }
                    $inputGroupBtn->setInnerElements($left);
                } else { // icon, string, other inputs
                    if (!isset($inputGroupAddon)) {
                        $inputGroupAddon = new Typography("div:input-group-addon");
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
        
        $_elements [] = array_merge($_elements, $this->innerElements);
        
        if (!empty($this->rightAddon)) {
            foreach ($this->rightAddon as $right) {
                if ($right instanceof Button || $right instanceof Dropdown) {
                    if (!isset ($inputGroupBtn)) {
                        $inputGroupBtn = new Typography("div:input-group-btn");
                    }
                    $inputGroupBtn->setInnerElements($right);
                } else { // icon, string, other inputs
                    if (!isset($inputGroupAddon)) {
                        $inputGroupAddon = new Typography("div:input-group-addon");
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
        
        if ($display) {
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
        $this->leftAddon = $leftAddon;
        return $this;
    }

    /**
     * @param Ambigous <boolean, array> $rightAddon
     */
    public function setRightAddon($rightAddon)
    {
        $this->rightAddon = $rightAddon;
        return $this;
    }
}
