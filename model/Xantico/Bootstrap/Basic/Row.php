<?php

namespace Xantico\Bootstrap\Basic;

class Row extends Typography
{
    public $screw; // Column

    protected $forForm; // boolean
    protected $requireIcon; // Icon
    protected $defaultScreenSize; // string 


    public function __construct($vars = array(), $attr = array())
    {
        parent::__construct("div:row", $vars, $attr);
        // @todo bs 4.0 if (forForm != "") div:form-row

        $this->forForm = isset ($vars ['forForm']) ? $vars ['forForm'] : "";
        $this->requireIcon = isset ($vars ['requireIcon']) && $vars ['requireIcon'] instanceof Icon ? $vars ['requireIcon'] : new Icon("asterisk", array("textContext" => "danger"));
        $this->defaultScreenSize
            = isset ($vars ['defaultScreenSize']) ? $vars ['defaultScreenSize'] : "md";

        $this->screw = array(
            "text" => "&nbsp;",
            "width" => null,
            "offset" => null,
            "attr" => array(),
            "css" => array()
        );
    }

    /**
     * @desc use items as col, then add as inner elements.
     * {@inheritDoc}
     * @see \model\Xantico\basic\Typography::render()
     */
    public function render($display = false)
    {
        if (!empty($this->items)) {
            foreach ($this->items as $input) {
                $item = $input ['text'];
                if ($item instanceof InputInterface || $item instanceof InputGroup
                    || $item instanceof Select || $item instanceof Textarea
                    || $item instanceof Button || $item instanceof ButtonGroup || $item instanceof ButtonToolbar) {
                    // for form is different from for usual.
                    if (!empty($input ['width'])) {
                        if (is_numeric($input ['width'])) {
                            /** @var Typography $col */
                            $col = new Typography("div:col-{$this->defaultScreenSize}-" . $input ['width']);
                        } else if (is_array($input ['width'])) {
                            $col = new Typography("div:" . $this->width [0]);
                            array_shift($input ['width']);
                            $col->appendCustomClass($input ['width']); // @todo for now.. 
                        }

                    } else {
                        $input ['width'] = round(12 / count($this->items));
                        $col = new Typography("div:col-{$this->defaultScreenSize}-" . $input ['width']);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }

                    if (!empty($input ['offset']) && isset ($col)) {
                        if (is_numeric($input ['offset'])) {
                            $col->appendCustomClass("col-{$this->defaultScreenSize}-offset-" . $input ['offset']);
                        } else if (is_array($input ['offset'])) {
                            $col->appendCustomClass($input ['offset']); // @todo for now..
                        }
                    }

                    if (!empty($input ['css']) && is_array($input ['css'])) {
                        $col->appendCustomClass($input ['css']);
                    }
                    if (!empty($input ['attr']) && is_array($input ['attr'])) {
                        $col->setAttrs($input ['attr']);
                    }

                    $formGrp = new Typography("div");
                    $formGrp->setCustomClass("form-group");
                    if (method_exists($item, "getValidationState") && !empty($item->getValidationState())) {
                        $formGrp->appendCustomClass("has-" . $item->getValidationState());
                        if (method_exists($item, "getHasFeedback") && $item->getHasFeedback() == true) {
                            $formGrp->appendCustomClass("has-feedback");
                        }
                    }
                    if (method_exists($item, "getCaption") && !empty($item->getCaption())) {
                        $_label = new Typography("label");
                        if ($this->forForm == "inline" || $this->forForm == "form-inline") {
                            $_label->setCustomClass("sr-only");
                        }
                        if (method_exists($item, "getValidationState") && !empty($item->getValidationState())) {
                            $_label->appendCustomClass("control-label");
                        }
                        if ($item instanceof InputGroup && empty($item->getId())) { // search input when input group id is empty.
                            $_for = $item->getId();
                        } else {
                            if (empty($item->getId())) {
                                $item->setId();
                            }
                            $_for = $item->getId();
                        }

                        $_label->appendAttrs(array("for" => $_for));

                        if (method_exists($item, "getIsRequired") && $item->getIsRequired() && !empty($this->requireIcon)) {
                            $_label->appendInnerElements(array($this->requireIcon, $item->getCaption()));
                        } else {
                            $_label->setInnerText($item->getCaption());
                        }

                        $formGrp->setInnerElements($_label);

                    }

                    $formGrp->appendInnerElements($item);
                    if (method_exists($item, "getHasFeedback") && $item->getHasFeedback() == true) {
                        $_icon = $item->getValidationState() == "success" ? "ok" : ($item->getValidationState() == "warning" ? "warning-sign" : "remove");
                        $feedbackIcon = new Icon($_icon);
                        $feedbackIcon->appendCustomClass("form-control-feedback");
                        $formGrp->appendInnerElements($feedbackIcon);
                    }

                    if (method_exists($item, "getHelp") && !empty($item->getHelp())) {
                        if (is_string($item->getHelp())) {
                            $_help = new Typography("small");
                            $_help->appendCustomClass(array("help-block"))
                                ->setText($item->getHelp());
                            $_help->setId();
                            $item->appendAttrs(array("aria-describedby" => $_help->getId()));
                        } else {
                            $_help = $item->getHelp();
                        }
                        $formGrp->appendInnerElements($_help);
                    }
                    $col->setInnerElements($formGrp);
                    $this->innerElements [] = $col;

                } else {
                    if (!empty($input ['width'])) {
                        if (is_numeric($input ['width'])) {
                            $col = new Typography("div:col-{$this->defaultScreenSize}-" . $input ['width']);
                        } else if (is_array($input ['width'])) {
                            $col = new Typography("div:" . $input ['width'] [0]);
                            array_shift($input ['width']);
                            $col->appendCustomClass($input ['width']); // @todo for now..
                        }

                    } else {
                        $input ['width'] = round(12 / count($this->items));
                        $col = new Typography("div:col-{$this->defaultScreenSize}-" . $input ['width']);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }

                    if (!empty($input ['offset']) && isset ($col)) {
                        if (is_numeric($input ['offset'])) {
                            $col->appendCustomClass("col-{$this->defaultScreenSize}-offset-" . $input ['offset']);
                        } else if (is_array($input ['offset'])) {
                            $col->appendCustomClass($input ['offset']); // @todo for now..
                        }
                    }

                    if (!empty($input ['attr']) && is_array($input ['attr'])) {
                        $col->setAttrs($input ['attr']);
                    }

                    $col->appendInnerElements($item);
                    $this->innerElements [] = $col;
                }
            }
        }
        $this->items = null;

        parent::render();

        if ($display == false) {
            return $this->html;
        } else {
            echo $this->html;
        }
    }

    /**
     * @return boolean $forForm
     */
    public function getForForm()
    {
        return $this->forForm;
    }

    /**
     * @param bool $forForm
     * @return $this
     */
    public function setForForm($forForm = true)
    {
        $this->forForm = $forForm;
        return $this;
    }

    /**
     * @param array $columns
     * @return $this|Typography
     */
    public function appendItems($columns)
    {
        if (!is_array($columns)) {
            $columns = array($columns);
        }
        for ($i = 0; $i < count($columns); $i++) {
            if (is_array($columns[$i])) {
                $columns[$i] ['text'] = isset($columns[$i] ['text']) ? $columns[$i] ['text'] : $this->screw ['text'];
                $columns[$i] ['width'] = isset($columns[$i] ['width']) ? $columns[$i] ['width'] : $this->screw ['width'];
                $columns[$i] ['offset'] = isset($columns[$i] ['offset']) ? $columns[$i] ['offset'] : $this->screw ['offset'];
                $columns[$i] ['attr'] = isset($columns[$i] ['attr']) ? $columns[$i] ['attr'] : $this->screw ['attr'];
                $columns[$i] ['css'] = isset($columns[$i] ['css']) ? $columns[$i] ['css'] : $this->screw ['css'];
            } else {
                $_column ['text'] = $columns[$i];
                $_column ['width'] = $this->screw ['width'];
                $_column ['offset'] = $this->screw ['offset'];
                $_column ['attr'] = $this->screw ['attr'];
                $_column ['css'] = $this->screw ['css'];

                $columns[$i] = $_column;
                unset ($_column);
            }
        }

        parent::appendItems($columns);
        return $this;
    }

    /**
     * @desc alias of setItems
     * @param array $cols
     * @return \model\Xantico\basic\Row
     */
    public function setColumns($cols)
    {
        return $this->setItems($cols);
    }

    /**
     * @param array $columns
     * @return $this|\model\Xantico\basic\Typography
     */
    public function setItems($columns)
    {
        // text [string], width [int|array], offset [int|array]
        if (!is_array($columns)) $columns = array($columns);
        for ($i = 0; $i < count($columns); $i++) {
            if (is_array($columns[$i])) {
                $columns[$i] ['text'] = isset($columns[$i] ['text']) ? $columns[$i] ['text'] : $this->screw ['text'];
                $columns[$i] ['width'] = isset($columns[$i] ['width']) ? $columns[$i] ['width'] : $this->screw ['width'];
                $columns[$i] ['offset'] = isset($columns[$i] ['offset']) ? $columns[$i] ['offset'] : $this->screw ['offset'];
                $columns[$i] ['attr'] = isset($columns[$i] ['attr']) ? $columns[$i] ['attr'] : $this->screw ['attr'];
                $columns[$i] ['css'] = isset($columns[$i] ['css']) ? $columns[$i] ['css'] : $this->screw ['css'];
            } else {
                $_column ['text'] = $columns[$i];
                $_column ['width'] = $this->screw ['width'];
                $_column ['offset'] = $this->screw ['offset'];
                $_column ['attr'] = $this->screw ['attr'];
                $_column ['css'] = $this->screw ['css'];

                $columns[$i] = $_column;
                unset ($_column);
            }
        }

        parent::setItems($columns);
        return $this;
    }

    public function getColumns()
    {
        return $this->items;
    }

    public function setColumn($index, $column)
    {
        $this->items [$index] = $column;
    }

    public function getColumn($index)
    {
        if (isset ($this->items [$index])) {
            return $this->items [$index];
        } else {
            return null;
        }
    }

    /**
     * @return Icon $requireIcon
     */
    public function getRequireIcon()
    {
        return $this->requireIcon;
    }

    /**
     * @param $requireIcon
     * @return $this
     */
    public function setRequireIcon($requireIcon)
    {
        if ($requireIcon instanceof Icon) {
            $this->requireIcon = $requireIcon;
        } else {
            $this->requireIcon = null;
        }

        return $this;
    }

    /**
     * @return the $defaultScreenSize
     */
    public function getDefaultScreenSize()
    {
        return $this->defaultScreenSize;
    }

    /**
     * @param Ambigous <string, \model\bootstrap\basic\Icon> $defaultScreenSize
     */
    public function setDefaultScreenSize($defaultScreenSize)
    {
        $this->defaultScreenSize = $defaultScreenSize;
        return $this;
    }

}




