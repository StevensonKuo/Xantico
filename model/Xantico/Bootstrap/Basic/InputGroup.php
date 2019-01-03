<?php

namespace Xantico\Bootstrap\Basic;

class InputGroup extends Input
{

    protected $leftAddon; // icon, text ,button or an array of them.
    protected $rightAddon; // ...  

    /**
     * @desc @todo will crash when inner input has validation message.
     * @param array $vars
     * @param array $attr
     */
    public function __construct($vars = array(), $attr = array())
    {
        parent::__construct("text", $vars, $attr);

        $this->type = "input-group";
        $this->leftAddon = isset ($vars ['leftAddon']) ? $vars ['leftAddon'] : false;
        $this->rightAddon = isset ($vars ['rightAddon']) ? $vars ['rightAddon'] : false;
    }

    /**
     * @desc left addon + original inner elements + right addon = new inner elements.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {

        $_elements = array();

        if (!empty($this->leftAddon) && is_array($this->leftAddon)) {
            if ($this->leftAddon[0] instanceof Button || $this->leftAddon[0] instanceof Dropdown) {
                $inputGroupAddonLeft = new Typography("span:input-group-btn");
            } else { // icon, string, other inputs
                $inputGroupAddonLeft = new Typography("span:input-group-addon");
            }
            $inputGroupAddonLeft->appendInnerElements($this->leftAddon);
        }

        if (!empty($this->rightAddon) && is_array($this->rightAddon)) {
            if ($this->rightAddon [0] instanceof Button || $this->rightAddon [0] instanceof Dropdown) {
                $inputGroupAddonRight = new Typography("span:input-group-btn");
            } else { // icon, string, other inputs
                $inputGroupAddonRight = new Typography("span:input-group-addon");
            }
            $inputGroupAddonRight->appendInnerElements($this->rightAddon);
        }

        parent::render();
        if (isset ($inputGroupAddonLeft)) {
            $_elements [] = $inputGroupAddonLeft;
        }
        $_elements [] = $this->html;
        if (isset ($inputGroupAddonRight)) {
            $_elements [] = $inputGroupAddonRight;
        }

        $inputGrp = new Typography("div:input-group");
        $inputGrp->setInnerElements($_elements);
        if (!empty($this->size)) {
            $inputGrp->appendCustomClass("input-group-" . $this->size);
        }

        $this->html = $inputGrp->render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @return the $leftAddon
     */
    public function getLeftAddon()
    {
        return $this->leftAddon;
    }

    /**
     * @param Ambigous <boolean, array> $leftAddon
     */
    public function setLeftAddon($leftAddon)
    {
        if (!is_array($leftAddon)) $leftAddon = array($leftAddon);
        $this->leftAddon = $leftAddon;
        return $this;
    }

    /**
     * @return the $rightAddon
     */
    public function getRightAddon()
    {
        return $this->rightAddon;
    }

    /**
     * @param Ambigous <boolean, array> $rightAddon
     */
    public function setRightAddon($rightAddon)
    {
        if (!is_array($rightAddon)) $rightAddon = array($rightAddon);
        $this->rightAddon = $rightAddon;
        return $this;
    }

}
