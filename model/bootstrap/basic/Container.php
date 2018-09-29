<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;

class Container extends Typography 
{
    protected $isFluid; //boolean
    
    public function __construct($innerElements = array (), $vars = array (), $attr = array ())
    {
        $this->isFluid = isset ($vars ['isFluid']) ? $vars ['isFluid'] : false;
        
        
        if ($this->isFluid == true) {
            parent::__construct("div:container", $vars, $attr);
        } else {
            parent::__construct("div:container-fluid", $vars, $attr);
        }
        
        if (is_array($innerElements)) {
            $this->innerElements = $innerElements;
        } else {
            $this->innerElements [] = $innerElements;
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



