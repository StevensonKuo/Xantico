<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Typography;
use model\bootstrap\basic\Input;

class Row extends Typography
{
    protected $forForm; // string; form type.
    protected $requireIcon; // Icon
    
    public static $DEFAULT_GRID_SCREEN_SIZE = "md"; // string  
    public $screw; // Grid
    
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:row", $vars, $attr);
        // @todo bs 4.0 if (forForm != "") div:form-row
        
        $this->forForm      = isset ($vars ['forForm']) ? $vars ['forForm'] : "";
        $this->requireIcon  = isset ($vars ['requireIcon']) && $vars ['requireIcon'] instanceof Icon ? $vars ['requireIcon'] : new Icon("asterisk", array ("textColorSet" => "danger"));
    
        $this->screw =  new Grid(new Input());
    }
    
    /**
     * @desc use items as col, then add as inner elements.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        if (!empty($this->items)) {
            foreach ($this->items as $input) {
                $item = $input->text;
                // @todo for form is different from for usual.
                if ($item instanceof Input || $item instanceof InputGroup 
                    || $item instanceof Select || $item instanceof Textarea  
                    || $item instanceof Button || $item instanceof ButtonGroup || $item instanceof ButtonToolbar) {
                    if (!empty($input->width)) {
                        if (is_numeric($input->width)) {
                            $col = new Typography("div:col-" . self::$DEFAULT_GRID_SCREEN_SIZE . "-" . $input->width);
                        } else if (is_array($input->width)) {
                            $col = new Typography("div:" . $this->width [0]);
                            array_shift($input->width);
                            $col->setCustomClass($input->width); // @todo for now.. 
                        }
                        
                    } else {
                        $input->width = round(12 / count($this->items)); 
                        $col = new Typography("div:col-md-" . $input->width);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }
                    if (method_exists($item, "getCaption") && !empty($item->getCaption())) {
                        $_label = new Typography("label");
                        if ($this->forForm == "inline" || $this->forForm == "form-inline") {
                            $_label->setCustomClass("sr-only");
                        }
                        if ($item instanceof InputGroup && empty($item->getId())) { // search input when input group id is empty.
                            $res = $item->search("input");
                            $_for = isset ($res [0]) ? $res [0]->getId() : "";
                        } else {
                            $_for = $item->getId();
                        }
                        
                        $_label->setAttrs(array ("for" => $_for));
                        
                        if (method_exists($item, "getIsRequired") && $item->getIsRequired() && !empty($this->requireIcon)) {
                            $_label->setInnerElements(array($this->requireIcon, $item->getCaption()));
                        } else {
                            $_label->setInnerText($item->getCaption());
                        }
                        
                        
                        $col->setInnerElements($_label);
                    }
                    $col->setInnerElements($item);
                    if (method_exists($item, "getHelp") && !empty($item->getHelp())) {
                        if (is_string($item->getHelp())) {
                            $_help = new HtmlTag("small");
                            $_help->setCustomClass(array ("form-text", "text-muted"))
                            ->setText($item->getHelp());
                        } else {
                            $_help = $item->getHelp();
                        }
                        $col->setInnerElements($_help);
                    }
                    $this->innerElements [] = $col;
                    
                } else {
                    if (!empty($input->width)) {
                        if (is_numeric($input->width)) {
                            $col = new Typography("div:col-".self::$DEFAULT_GRID_SCREEN_SIZE."-" . $input->width);
                        } else if (is_array($input->width)) {
                            $col = new Typography("div:" . $input->width [0]);
                            array_shift($input->width);
                            $col->setCustomClass($input->width); // @todo for now..
                        }
                        
                    } else {
                        $input->width = round(12 / count($this->items));
                        $col = new Typography("div:col-md-" . $input->width);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }
                    $col->setInnerElements($item);
                    $this->innerElements [] = $col;
                }
            } 
        }
        unset ($this->items);
        
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
     * @param Ambigous <unknown, multitype:, array, NULL> $grids
     */
    public function setItems($grids)
    {
        if (!is_array($grids)) $grids = array ($grids);
        for ($i = 0; $i < count($grids); $i ++) {
            if (is_array ($grids[$i])) {
                $_input = isset($grids[$i] ['text']) ? $grids[$i] ['text'] : new Input();
                $_width = isset($grids[$i] ['width']) ? $grids[$i] ['width'] : null;
                
                $grids[$i] = new Grid($_input, $_width);
            } else if (!($grids[$i] instanceof Grid)) {
                $grids[$i] = new Grid($grids[$i]);
            }
        }
        
        $this->items = $grids;
        return $this;
    }
    
    /**
     * @return the $requireIcon
     */
    public function getRequireIcon()
    {
        return $this->requireIcon;
    }

    /**
     * @param \model\bootstrap\basic\Icon $requireIcon
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
}

/**
 * @desc Inputs inside of Form Row 
 * @author metatronangelo
 */
class Grid {
    var $text; // Input
    var $width; // int, max 12, could be null, could be array
    
    public function __construct($input = null, $width = null) {
        $this->text = $input;
        $this->width = $width;
    }
}




