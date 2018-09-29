<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Typography;

class ProgressBar extends Typography
{
    public $screw; // array
    
    protected $min; // int
    protected $max; // int
    protected $now; // int
    protected $isStriped; // boolean
    protected $isAnimated; // boolean
    
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:progress", $vars, $attr);
        
        $this->min          = isset($vars['min']) ? $vars['min'] : 0;
        $this->max          = isset($vars['max']) ? $vars['max'] : 100;
        $this->now          = isset($vars['now']) ? $vars['now'] : 0;
        $this->isStriped    = isset($vars['isStriped']) ? $vars['isStriped'] : false;
        $this->isAnimated   = isset($vars['isAnimated']) ? $vars['isAnimated'] : false;
        
        $this->screw        = array (
            "now"           => 0, 
            "context"       => "", 
            "text"          => "", 
            "isStriped"     => false, 
            "isAnimated"    => false
        );
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        if (!empty($this->items)) {
            foreach ($this->items as $pgbar) {
                $bar = new Typography("div:progress-bar", null, array("role" => "progressbar"));
                if ($pgbar ['now'] < 2 && !empty($pgbar ['text'])) {
                    $bar->appendCustomStyle("min-width: 2em;");
                } else {
                    $bar->appendCustomStyle("width: {$pgbar ['now']}%");
                }
                
                if (!empty($pgbar ['context'])) {
                    $bar->appendCustomClass("progress-bar-" . $pgbar ['context']);
                }
                if ($pgbar ['isStriped'] == true) {
                    $bar->appendCustomClass("progress-bar-striped");
                    if ($pgbar ['isAnimated'] == true) {
                        $bar->appendCustomClass("active");
                    }
                }
                
                if (!empty($pgbar ['text'])) {
                    $bar->appendInnerElements($pgbar ['text']);
                } else {
                    $textSpan = new HtmlTag("span");
                    $textSpan->appendCustomClass("sr-only");
                    $textSpan->setText($pgbar ['now'] . "% Complete");
                    $bar->appendInnerElements($textSpan);
                }
                
                $bars [] = $bar;
                $this->items = null;
            }
        } else {
            $bar = new Typography("div:progress-bar", null, array("role" => "progressbar"));
            $bar->appendAttrs(
                array (
                    "aria-valuenow" => $this->now,
                    "aria-valuemin" => $this->min,
                    "aria-valuemax" => $this->max
                ));
            if ($this->now < 2 && !empty($this->innerText)) {
                $bar->appendCustomStyle("min-width: 2em;");
            } else {
                $bar->appendCustomStyle("width: {$this->now}%");
            }
            
            
            if (!empty($this->context)) {
                $bar->appendCustomClass("progress-bar-" . $this->context);
                $this->context = "";
            }
            if ($this->isStriped == true) {
                $bar->appendCustomClass("progress-bar-striped");
                if ($this->isAnimated == true) {
                    $bar->appendCustomClass("active");
                }
            }
            
            if (!empty($this->innerText)) {
                $bar->appendInnerElements($this->innerText);
            } else {
                $textSpan = new HtmlTag("span");
                $textSpan->appendCustomClass("sr-only");
                $textSpan->setText($this->now . "% Complete");
                $bar->appendInnerElements($textSpan);
            }
            
            $bars = array ($bar);
        }
        
        $this->innerElements = $bars; 
        $this->innerText = "";
        
        parent::render();
        
        if ($display == true) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    /**
     * @return the $min
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return the $max
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return the $now
     */
    public function getNow()
    {
        return $this->now;
    }

    /**
     * @return the $isStriped
     */
    public function getIsStriped()
    {
        return $this->isStriped;
    }

    /**
     * @param number $min
     */
    public function setMin($min = 0)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @param number $max
     */
    public function setMax($max = 100)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * @param number $now
     */
    public function setNow($now)
    {
        $this->now = $now;
        return $this;
    }

    /**
     * @param array of PgBar $items
     */
    public function setItems($nowSet)
    { 
        if (!empty($nowSet)) {
            for ($i = 0; $i < count($nowSet); $i ++) {
                if (is_array ($nowSet[$i])) {
                    $nowSet[$i] ['now']         = isset($nowSet[$i] ['now']) ? $nowSet[$i] ['now'] : $this->screw ['now'];
                    $nowSet[$i] ['context']     = isset($nowSet[$i] ['context']) ? $nowSet[$i] ['context'] : $this->screw ['context'];
                    $nowSet[$i] ['text']        = isset($nowSet[$i] ['text']) ? $nowSet[$i] ['text'] : $this->screw ['text'];
                    $nowSet[$i] ['isStriped']   = isset($nowSet[$i] ['isStriped']) ? $nowSet[$i] ['isStriped'] : $this->screw ['isStriped'];
                    $nowSet[$i] ['isAnimated']  = isset($nowSet [$i] ['isAnimated']) ? $nowSet [$i] ['isAnimated'] : $this->screw ['isAnimated'];
                } else {
                    $_now ['now']         = $nowSet [$i];
                    $_now ['context']     = $this->screw ['context'];
                    $_now ['text']        = $this->screw ['text'];
                    $_now ['isStriped']   = $this->screw ['isStriped'];
                    $_now ['isAnimated']  = $this->screw ['isAnimated'];
                    $nowSet [$i] = $_now;
                    unset ($_now);
                }
            }
        }
        
        parent::setItems($nowSet);
        return $this;
    }
    
    /**
     * @param array of PgBar $items
     */
    public function appendItems($nowSet)
    {
        if (!empty($nowSet)) {
            for ($i = 0; $i < count($nowSet); $i ++) {
                if (is_array ($nowSet[$i])) {
                    $nowSet[$i] ['now']         = isset($nowSet[$i] ['now']) ? $nowSet[$i] ['now'] : $this->screw ['now'];
                    $nowSet[$i] ['context']     = isset($nowSet[$i] ['context']) ? $nowSet[$i] ['context'] : $this->screw ['context'];
                    $nowSet[$i] ['text']        = isset($nowSet[$i] ['text']) ? $nowSet[$i] ['text'] : $this->screw ['text'];
                    $nowSet[$i] ['isStriped']   = isset($nowSet[$i] ['isStriped']) ? $nowSet[$i] ['isStriped'] : $this->screw ['isStriped'];
                    $nowSet[$i] ['isAnimated']  = isset($nowSet [$i] ['isAnimated']) ? $nowSet [$i] ['isAnimated'] : $this->screw ['isAnimated'];
                } else {
                    $_now ['now']         = $nowSet [$i];
                    $_now ['context']     = $this->screw ['context'];
                    $_now ['text']        = $this->screw ['text'];
                    $_now ['isStriped']   = $this->screw ['isStriped'];
                    $_now ['isAnimated']  = $this->screw ['isAnimated'];
                    $nowSet [$i] = $_now;
                    unset ($_now);
                }
            }
        }
        parent::appendItems($nowSet);
        return $this;
    }

    /**
     * @param boolean $isStriped 
     */
    public function setIsStriped($isStriped = true)
    {
        $this->isStriped = $isStriped;
        return $this;
    }
    
    /**
     * @return the $isAnimated
     */
    public function getIsAnimated()
    {
        return $this->isAnimated;
    }

    /**
     * @param field_type $isAnimated
     */
    public function setIsAnimated($isAnimated = true)
    {
        $this->isAnimated = $isAnimated;
        return $this;
    }


}


