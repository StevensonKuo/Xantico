<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Typography;
use model\bootstrap\basic\Input;

class Row extends Typography
{
    protected $forForm; // string; form type.
    protected $columnSize; // string; for bs grid system.
    protected $rowGrids; // array; row items.
    
    public $screw;
    
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:row", $vars, $attr);
        // @todo bs 4.0 if (forForm != "") div:form-row
        
        $this->forForm      = isset ($vars ['forForm']) ? $vars ['forForm'] : "";
        $this->columnSize   = isset ($vars ['columnSize']) ? $vars ['columnSize'] : "md";
        $this->rowGrids     = isset ($vars ['rowGrids']) ? $vars ['rowGrids'] : array ();
    
        $this->screw =  new Grid(new Input());
    }
    
    /**
     * @desc use items as col, then add as inner elements.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        if (!empty($this->rowGrids)) {
            foreach ($this->rowGrids as $input) {
                $item = $input->input;
                // @todo for form is different from for usual.
                if ($item instanceof Input || $item instanceof InputGroup || $item instanceof Button) {
                    if (!empty($input->width)) {
                        if (is_numeric($input->width)) {
                            $col = new Typography("div:col-{$this->columnSize}-" . $input->width);
                        } else if (is_array($input->width)) {
                            $col = new Typography("div:" . $this->width [0]);
                            array_shift($this->width);
                            $col->setCustomClass($this->width); // @todo for now.. 
                        }
                        
                    } else {
                        $input->width = round(12 / count($this->rowGrids)); 
                        $col = new Typography("div:col-{$this->columnSize}-" . $input->width);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }
                    if (method_exists($item, "getCaption") && !empty($item->getCaption())) {
                        $_label = new Typography("label");
                        if ($this->forForm == "inline") $_label->setCustomClass("sr-only");
                        if ($item instanceof InputGroup && empty($item->getId())) { // search input when input group id is empty.
                            $res = $item->search("input");
                            $_for = isset ($res [0]) ? $res [0]->getId() : "";
                        } else {
                            $_for = $item->getId();
                        }
                        $_label->setAttrs(array ("for" => $_for));
                        if (method_exists($item, "getisRequired") && $item->getIsRequired()) {
                            $_requireIcon = new Icon("asterisk", array ("colorSet" => "danger"));
                            $_label->setInnerElements($_requireIcon);
                        }
                        $_label->setInnerText($item->getCaption());
                        
                        $col->setInnerElements($_label);
                    }
                    $col->setInnerElements($item);
                    if (method_exists($item, "getHelp") && !empty($item->getHelp())) {
                        $_help = new HtmlTag("small");
                        $_help->setCustomClass(array ("form-text", "text-muted"))
                        ->setText($item->getHelp());
                        $col->setInnerElements($_help);
                    }
                    $this->innerElements [] = $col;
                } else {
                    if (!empty($input->width)) {
                        if (is_numeric($input->width)) {
                            $col = new Typography("div:col-{$this->columnSize}-" . $input->width);
                        } else if (is_array($input->width)) {
                            $col = new Typography("div:" . $this->width [0]);
                            array_shift($this->width);
                            $col->setCustomClass($this->width); // @todo for now..
                        }
                        
                    } else {
                        $input->width = round(12 / count($this->rowGrids));
                        $col = new Typography("div:col-{$this->columnSize}-" . $input->width);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }
                    $col->setInnerElements($item);
                    $this->innerElements [] = $col;
                }
            } 
        }
        
        parent::render();
        
        if ($display == false) {
            return $this->html;
        } else {
            echo $this->html;
        }
    }

    /**
     * @return the $forForm
     */
    public function getForForm()
    {
        return $this->forForm;
    }

    /**
     * @param field_type $forForm
     */
    public function setForForm($forForm = true)
    {
        $this->forForm = $forForm;
        return $this;
    }
    
    /**
     * @return the $columnSize
     */
    public function getColumnSize()
    {
        return $this->columnSize;
    }

    /**
     * @param field_type $columnSize
     */
    public function setColumnSize($columnSize)
    {
        switch ($columnSize) {
            case 1:
                //                 $this->size = "miner"; // preserved.
            case 2:
                $this->columnSize = "xs";
                break;
            case 3:
                $this->columnSize = "sm";
                break;
            case 4:
                $this->columnSize = "md";
                break;
            case 5:
                $this->columnSize = "lg";
                break;
            default:
                $this->columnSize = $columnSize;
                
        }
        
        $this->columnSize = $columnSize;
        
        return $this;
    }
    /**
     * @return the $grids
     */
    public function getRowGrids()
    {
        return $this->rowGrids;
    }

    /**
     * @param Ambigous <unknown, multitype:, array, NULL> $grids
     */
    public function setRowGrids($grids)
    {
        if (!is_array($grids)) $grids = array ($grids);
        for ($i = 0; $i < count($grids); $i ++) {
            if (is_array ($grids[$i])) {
                $_input = isset($grids[$i] ['input']) ? $grids[$i] ['input'] : new Input();
                $_width = isset($grids[$i] ['width']) ? $grids[$i] ['width'] : null;
                
                $grids[$i] = new Grid($_input, $_width);
            } else if (!($grids[$i] instanceof Grid)) {
                $grids[$i] = new Grid($grids[$i]);
            }
        }
        
        $this->rowGrids = $grids;
        return $this;
    }



    
}

/**
 * @desc Inputs inside of Form Row 
 * @author metatronangelo
 */
class Grid {
    var $input; // Input
    var $width; // int, max 12, could be null
    
    public function __construct(HtmlTag $input, $width = null) {
        $this->input = $input;
        $this->width = $width;
    }
}




