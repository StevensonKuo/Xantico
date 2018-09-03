<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Typography;
use model\bootstrap\basic\Input;

class FormRow extends Typography
{
    public $screw;
    
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:form-row", $vars, $attr);
    
        $this->screw =  new FGrid(new Input());
    }
    
    /**
     * @desc use items as col, then add as inner elements.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render($display = false) {
        if (!empty($this->items)) {
            foreach ($this->items as $input) {
                $item = $input->input;
                if ($item instanceof Input) {
                    if (!empty($input->width)) {
                        $col = new Typography("div:col-md-" . $input->width);
                    } else {
                        $input->width = round(12 / count($this->items)); 
                        $col = new Typography("div:col-md-" . $input->width);
                        // $col = new Typography("div:col"); // @todo bs 4.0
                    }
                    if (!empty($item->getCaption())) {
                        $_label = new Typography("label");
                        $_label->setAttrs(array ("for" => $item->getId()));
                        if ($item->getIsRequired()) {
                            $_requireIcon = new Icon("asterisk", array ("colorSet" => "danger"));
                            $_label->setInnerElements($_requireIcon);
                        }
                        $_label->setInnerText($item->getCaption());
                        
                        $col->setInnerElements($_label);
                    }
                    $col->setInnerElements($item);
                    if (!empty($item->getHelp())) {
                        $_help = new HtmlTag("small");
                        $_help->setCustomClass(array ("form-text", "text-muted"))
                        ->setText($item->getHelp());
                        $col->setInnerElements($_help);
                    }
                    $this->innerElements [] = $col;
                }
            }
            unset ($this->items); // will be consider as ul/ol items if do not unset it.
        }
        
        parent::render();
        
        if ($display == false) {
            return $this->html;
        } else {
            echo $this->html;
        }
    }

    /**
     * @desc check if they are FGrids.
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setItems()
     */
    public function setItems($items = array ()) {
        if (!is_array($items)) $items = array ($items);
        for ($i = 0; $i < count($items); $i ++) {
            if (is_array ($items[$i])) {
                $_input = isset($items[$i] ['input']) ? $items[$i] ['input'] : new Input();
                $_width = isset($items[$i] ['width']) ? $items[$i] ['width'] : null;
                
                $items[$i] = new FGrid($_input, $_width);
            } else if (!($items[$i] instanceof FGrid)) {
                $items[$i] = new FGrid($items[$i]);
            }
        }
        
        $this->items = $items;
        return $this;
    }
    
}

/**
 * @desc Inputs inside of Form Row 
 * @author metatronangelo
 */
class FGrid {
    var $input; // Input
    var $width; // int, max 12, could be null
    
    public function __construct(Input $input, $width = null) {
        $this->input = $input;
        $this->width = $width;
    }
}




