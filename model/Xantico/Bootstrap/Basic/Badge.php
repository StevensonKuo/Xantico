<?php

namespace Xantico\Bootstrap\Basic;

class Badge extends Typography
{

    /**
     * @desc constructor
     * @param string $text
     * @param array $vars
     * @param array $attr
     */
    public function __construct($text = "", $vars = array(), $attr = array())
    {
        parent::__construct("span", $vars, $attr);

        $this->type = "badge";
        $this->innerText = !empty($text) ? $text : "badge";
        $this->align = !empty($this->align) ? $this->align : "right"; // default alignment is in right.
    }

    /**
     * generate HTML.
     * @param bool $display
     * @return string|bool
     */
    function render($display = false)
    {
        $class [] = $this->type;
        if (!empty($this->context)) $class [] = $this->type . '-' . $this->context;
        if (!empty($this->align)) $class [] = $this->type . '-' . $this->align;

        $this->customClass = $class;
        // set will append classes.

        $html = parent::render();

        $this->html = $html;

        if ($display == true) {
            echo $this->html;
            return true;
        } else {
            return $this->html;
        }
    }
}
