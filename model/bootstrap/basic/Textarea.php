<?php
namespace model\bootstrap\basic;

class Textarea extends Input 
{
    protected $rows; // int
    protected $cols; // int
    
    public function __construct($vars = array (), $attrs = array ())
    {
        parent::__construct("textarea", $vars, $attrs);
        // @todo how many I shall set to rows and cols in a default textarea?
    }
    
    /**
     * @return the $rows
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return the $cols
     */
    public function getCols()
    {
        return $this->cols;
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
     * @param field_type $cols
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        $this->attrs ['cols'] = $cols;
        return $this;
    }


    
}

