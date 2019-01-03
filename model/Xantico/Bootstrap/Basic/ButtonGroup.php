<?php

namespace Xantico\Bootstrap\Basic;

class ButtonGroup extends Typography
{

    protected $isVertical; // boolean, for vertical button group.
    protected $justified; // boolean, justified table-cell button group.

    public function __construct($vars = array(), $attr = array())
    {

        $this->isVertical = isset ($vars ['isVertical']) ? $vars ['isVertical'] : false;
        $this->justified = isset ($vars ['justified']) ? $vars ['justified'] : false;

        if ($this->isVertical == true) {
            parent::__construct("div:btn-group-vertical", $vars, $attr);
        } else {
            parent::__construct("div:btn-group", $vars, $attr);
        }
    }

    /**
     *
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {

        $this->appendAttrs(array("role" => "group"));

        if ($this->isVertical == true) {
            $_class = array();
            foreach ($this->customClass as $cls) {
                $_class [] = str_replace("btn-group", "btn-group-vertical", $cls);
            }
            $this->customClass = $_class;
            unset ($_class);
        }

        if (!empty($this->size)) {
            $this->appendCustomClass("btn-group-" . $this->size);
        }

        if ($this->justified == true) {
            $this->appendCustomClass("btn-group-justified");
        }

        if (!empty($this->context) && $this->context != "default") {
            foreach ($this->innerElements as &$ele) {
                if ($ele instanceof Typography && $this->context != $ele->getContext()) {
                    $ele->setContext($this->context);
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
     * @return the $isVertical
     */
    public function getIsVertical()
    {
        return $this->isVertical;
    }

    /**
     * @param Ambigous <boolean, unknown> $isVertical
     */
    public function setIsVertical($isVertical = true)
    {
        $this->isVertical = $isVertical;
        return $this;
    }

    /**
     * @return the $justified
     */
    public function getJustified()
    {
        return $this->justified;
    }

    /**
     * @param Ambigous <boolean, array> $justified
     */
    public function setJustified($justified)
    {
        $this->justified = $justified;
        return $this;
    }


}
