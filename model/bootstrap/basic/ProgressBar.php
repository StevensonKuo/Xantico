<?php
namespace model\bootstrap\basic;

use model\bootstrap\HtmlTag;
use model\bootstrap\basic\Typography;

class ProgressBar extends Typography
{
    protected $min; // int
    protected $max; // int
    protected $now; // int
    protected $isStriped; // boolean
    protected $isAnimated; // boolean
    
    public $screw; // PgBar;
    
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
        
        $this->screw        = new PgBar();
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
                if ($pgbar->now < 2 && !empty($pgbar->text)) {
                    $bar->setCustomStyle("min-width: 2em;");
                } else {
                    $bar->setCustomStyle("width: {$pgbar->now}%");
                }
                
                if (!empty($pgbar->colorSet)) {
                    $bar->setCustomClass("progress-bar-" . $pgbar->colorSet);
                }
                if ($pgbar->isStriped == true) {
                    $bar->setCustomClass("progress-bar-striped");
                    if ($pgbar->isAnimated == true) {
                        $bar->setCustomClass("active");
                    }
                }
                
                if (!empty($pgbar->text)) {
                    $bar->setInnerElements($pgbar->text);
                } else {
                    $textSpan = new HtmlTag("span");
                    $textSpan->setCustomClass("sr-only");
                    $textSpan->setText($pgbar->now . "% Complete");
                    $bar->setInnerElements($textSpan);
                }
                
                $bars [] = $bar;
                $this->items = null;
            }
        } else {
            $bar = new Typography("div:progress-bar", null, array("role" => "progressbar"));
            $bar->setAttrs(
                array (
                    "aria-valuenow" => $this->now,
                    "aria-valuemin" => $this->min,
                    "aria-valuemax" => $this->max
                ));
            if ($this->now < 2 && !empty($this->text)) {
                $bar->setCustomStyle("min-width: 2em;");
            } else {
                $bar->setCustomStyle("width: {$this->now}%");
            }
            
            
            if (!empty($this->colorSet)) {
                $bar->setCustomClass("progress-bar-" . $this->colorSet);
                $this->colorSet = "";
            }
            if ($this->isStriped == true) {
                $bar->setCustomClass("progress-bar-striped");
                if ($this->isAnimated == true) {
                    $bar->setCustomClass("active");
                }
            }
            
            if (!empty($this->text)) {
                $bar->setInnerElements($this->text);
            } else {
                $textSpan = new HtmlTag("span");
                $textSpan->setCustomClass("sr-only");
                $textSpan->setText($this->now . "% Complete");
                $bar->setInnerElements($textSpan);
            }
            
            $bars = array ($bar);
        }
        
        $this->innerElements = $bars; 
        $this->text = "";
        
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
                    $_now = isset($nowSet[$i] ['now']) ? $nowSet[$i] ['now'] : 0;
                    $_colorSet = isset($nowSet[$i] ['colorSet']) ? $nowSet[$i] ['colorSet'] : "";
                    $_text = isset($nowSet[$i] ['text']) ? $nowSet[$i] ['text'] : "";
                    $_isStrpied = isset($nowSet[$i] ['isStriped']) ? $nowSet[$i] ['isStrpied'] : false;
                    $_isAnimated = isset($nowSet [$i] ['isAnimated']) ? $nowSet [$i] ['isAnimated'] : false;
                    
                    $nowSet[$i] = new PgBar($_now, $_colorSet, $_text, $_isStrpied, $_isAnimated);
                } else if (!($nowSet[$i] instanceof PgBar)) {
                    unset ($nowSet[$i]);
                }
            }
        }
        $this->items = $nowSet;
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

/**
 * @desc nowSet 用的物件 
 */
class PgBar {
    var $now;
    var $colorSet;
    var $text;
    var $isStriped; 
    var $isAnimated;
    
    public function __construct($now = 0, $colorSet = "", $text = "", $isStriped = false, $isAnimated = false) {
        $this->now = $now;
        $this->colorSet = $colorSet;
        $this->text = $text;
        $this->isStriped = $isStriped;  
        $this->isAnimated = $isAnimated;
    }
}


