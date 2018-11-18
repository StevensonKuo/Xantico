<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Container extends Typography 
{
    protected $isFluid; //boolean
    
    public function __construct($innerElements = array (), $vars = array (), $attr = array ())
    {
        parent::__construct("div:container", $vars, $attr);
        
        $this->isFluid = isset ($vars ['isFluid']) ? $vars ['isFluid'] : false;
        
        if (is_array($innerElements)) {
            $this->innerElements = $innerElements;
        } else {
            $this->innerElements [] = $innerElements;
        }
    }
    
    /**
     * @desc render 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        if ($this->isFluid == true) {
            if (!in_array("container-fluid", $this->customClass)) {
                if (in_array ("container", $this->customClass)) {
                    $_key = array_search("container", $this->customClass);
                    $this->customClass [$_key] = "container-fluid";
                } else {
                    $this->customClass [] = "container-fluid";
                }
            }
        } else {
            if (!in_array("container", $this->customClass)) {
                if (in_array ("container-fluid", $this->customClass)) {
                    $_key = array_search("container-fluid", $this->customClass);
                    $this->customClass [$_key] = "container";
                } else {
                    $this->customClass [] = "container";
                }
            }
        }
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @return the $isFluid
     */
    public function getIsFluid()
    {
        return $this->isFluid;
    }

    /**
     * @param Ambigous <boolean, array> $isFluid
     */
    public function setIsFluid($isFluid = true)
    {
        $this->isFluid = $isFluid;
        return $this;
    }



}



