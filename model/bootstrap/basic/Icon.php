<?php
namespace model\bootstrap\basic;

class Icon extends Typography 
{
    protected $icon; // string 
    protected $iconSet; // string
    
    /**
     * constructor
     * @param array $vars
     * @return \Bootstrap\Aceadmin\Icon
     */
    public function __construct($icon = "arrow-right", $vars = array (), $attrs = array())
    {
        parent::__construct("span", $vars);
        
        $this->type     = "icon";
        $this->icon     = isset($icon) ? $icon : "arrow-right";
        $this->iconSet  = isset ($vars ['iconSet']) ? $vars ['iconSet'] : "glyphicon";
        $this->align    = "left"; // Icon default alignment is in left.
        
    }
    
    /**
     * 
     * @param string $display
     * @return string
     */
    public function render ($display = false) {
        $this->setAttrs(array ("aria-hidden" => "true"));
        if (!empty($this->iconSet)) {
            $class [] = $this->iconSet . " " . $this->iconSet . "-" . $this->icon;
        } else {
            $class [] = $this->icon;
        }
        
        if (!empty($this->align))       $class [] = "icon-on-" . $this->align;
        if (!empty($this->textColorSet))    $class [] = "text-" . $this->textColorSet;
        
        $this->setCustomClass($class);
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * 如果是陣列的話第一個是字集
     * @param string $icon
     * @return \Bootstrap\Aceadmin\Icon
     */
    public function setIcon ($icon = "") {
        $this->icon = $icon;
        
        return $this;
    }
    
    /**
     * @return the $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    /**
     * @return the $iconSet
     */
    public function getIconSet()
    {
        return $this->iconSet;
    }

    /**
     * @param field_type $iconSet
     */
    public function setIconSet($iconSet)
    {
        $this->iconSet = $iconSet;
        return $this;
    }

    
}


