<?php

namespace Xantico\Bootstrap\Basic;

class Textarea extends Input
{
    protected $rows; // int
    protected $cols; // int

    public function __construct($innerText = "", $vars = array(), $attrs = array())
    {
        $this->rows = isset ($vars ['rows']) ? $vars ['rows'] : "3";
        $this->cols = isset ($vars ['cols']) ? $vars ['cols'] : null;
        $attrs ['rows'] = $this->rows;
        if ($this->cols === null) $attrs ['cols'] = $this->cols;

        parent::__construct("textarea", $vars, $attrs);

        $this->innerText = $innerText;
    }

    /**
     * @return the $rows
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param field_type $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        $this->attrs ['rows'] = $rows;
        return $this;
    }

    /**
     * @return the $cols
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param field_type $cols
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        $this->attrs ['cols'] = $cols;
        return $this;
    }


}

