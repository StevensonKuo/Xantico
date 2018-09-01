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
     * 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        
        if (!empty($this->size)) {
            $this->setCustomClass("input-group-" . $this->size);
        }

        if (!empty($this->leftAddon)) {
            // @todo add left addons
        }
        if (!empty($this->rightAddon)) {
            // @todo add right addons
        }
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc 按鈕大小, 可輸入 1~5, 數字愈大按鈕愈大 [xs|sm|lg]
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
