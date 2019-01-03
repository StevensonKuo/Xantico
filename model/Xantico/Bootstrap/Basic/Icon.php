<?php
namespace Xantico\Bootstrap\Basic;

class Icon extends Typography
{
    protected $icon; // string 
    protected $iconSet; // string

    /**
     * constructor
     * @param array $vars
     * @return Icon
     */
    public function __construct($icon = "arrow-right", $vars = array(), $attrs = array())
    {
        parent::__construct("span", $vars);

        $this->type = "icon";
        $this->icon = isset($icon) ? $icon : "arrow-right";
        $this->iconSet = isset ($vars ['iconSet']) ? $vars ['iconSet'] : "glyphicon";
        // $this->align    = "left"; // Icon default alignment is in left.

    }

    /**
     *
     * @param string $display
     * @return string
     */
    public function render($display = false)
    {
        $this->appendAttrs(array("aria-hidden" => "true"));
        if (!empty($this->iconSet)) {
            $class [] = $this->iconSet . " " . $this->iconSet . "-" . $this->icon;
        } else {
            $class [] = $this->icon;
        }

        if (!empty($this->align)) $class [] = "icon-on-" . $this->align;
        if (!empty($this->textContext)) $class [] = "text-" . $this->textContext;

        $this->appendCustomClass($class);

        parent::render();

        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }

    /**
     * @return the $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return \bootstrap\basic\Icon
     */
    public function setIcon($icon = "")
    {
        $this->icon = $icon;

        return $this;
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


