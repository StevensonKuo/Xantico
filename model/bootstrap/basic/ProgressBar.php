<?php
namespace model\bootstrap\basic;


use model\bootstrap\basic\Typography;

class ProgressBar extends Typography
{
    protected $min; // int
    protected $max; // int
    protected $now; // int
    protected $nowSet; // array
    protected $isStriped; // boolean
    
    public $screw; // PgBar;
    
    /**
     * @desc contructor
     * @param array $vars [header]
     * @param array $attr tag attributes... 
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("div:progress", $vars, $attr);
        
        $this->type     = "progress";
        $this->min      = isset($vars['min']) ? $vars['min'] : 0;
        $this->max      = isset($vars['max']) ? $vars['max'] : 100;
        $this->now      = isset($vars['now']) ? $vars['now'] : 0;
        $this->nowSet   = isset($vars['nowSet']) ? $vars['nowSet'] : array();
        $this->isStriped = isset($vars['isStriped']) ? $vars['isStriped'] : false;
        // alert 的 color set 預設為 success, 不為 default/primary
        
        $this->screw    = new PgBar();
    }
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        if (!empty($this->nowSet)) {
            foreach ($this->nowSet as $pgbar) {
                $bar = new Typography("div:progress-bar", null, array("role" => "progressbar"));
                $bar->setCustomStyle("width: {$pgbar->now}%");
                
                if ($pgbar->isStriped == true) {
                    $bar->setCustomClass("progress-bar-striped");
                } else if (!empty($pgbar->colorSet)) {
                    $bar->setCustomClass("progress-bar-" . $pgbar->colorSet);
                }
                
                $memo = new Typography("span:sr-only");
                $memo->setInnerText($pgbar->text);
                $bar->setInnerElements($memo);
                
                $bars [] = $bar;
            }
        } else {
            $bar = new Typography("div:progress-bar", null, array("role" => "progressbar"));
            $bar->setAttrs(
                array (
                    "aria-valuenow" => $this->now,
                    "aria-valuemin" => $this->min,
                    "aria-valuemax" => $this->max
                ));
            $bar->setCustomStyle("width: {$this->now}%");
            if ($this->isStriped == true) {
                $bar->setCustomClass("progress-bar-striped");
            } else if (!empty($this->colorSet)) {
                $bar->setCustomClass("progress-bar-" . $this->colorSet);
                $this->colorSet = "";
            }
            
            $memo = new Typography("span:sr-only");
            $memo->setInnerText($this->text);
            $bar->setInnerElements($memo);
            
            $bars = array ($bar);
        }
        
        $this->innerElements = $bars; 
        $this->text = "";
        
        parent::render();
        
        if ($display) {
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
     * @return the $nowSet
     */
    public function getNowSet()
    {
        return $this->nowSet;
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
     * @param array of PgBar $nowSet
     */
    public function setNowSet($nowSet)
    { 
        if (!empty($nowSet)) {
            for ($i = 0; $i < count($nowSet); $i ++) {
                if (is_array ($nowSet[$i])) {
                    $_now = isset($nowSet[$i] ['now']) ? $nowSet[$i] ['now'] : 0;
                    $_colorSet = isset($nowSet[$i] ['colorSet']) ? $nowSet[$i] ['colorSet'] : "";
                    $_text = isset($nowSet[$i] ['text']) ? $nowSet[$i] ['text'] : "";
                    $_isStrpied = isset($nowSet[$i] ['isStriped']) ? $nowSet[$i] ['isStrpied'] : false;
                    
                    $nowSet[$i] = new PgBar($_now, $_colorSet, $_text, $_isStrpied);
                } else if (!($nowSet[$i] instanceof PgBar)) {
                    unset ($nowSet[$i]);
                }
            }
        }
        $this->nowSet = $nowSet;
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

}

/**
 * @desc nowSet 用的物件 
 */
class PgBar {
    var $now;
    var $colorSet;
    var $text;
    var $isStriped; 
    
    public function __construct($now = 0, $colorSet = "", $text = "", $isStriped = false) {
        $this->now = $now;
        $this->colorSet = $colorSet;
        $this->text = $text;
        $this->isStriped = $isStriped;  
    }
}


