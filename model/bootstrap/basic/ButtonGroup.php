<?php
namespace model\bootstrap\basic;

class ButtonGroup extends Typography 
{
 
    protected $isVertical; // boolean, for vertical button group.
    protected $justified; // boolean, justified table-cell button group.
    
    public function __construct($vars = array (), $attr = array())
    {
        parent::__construct("div:btn-group", $vars, $attr);
        
        $this->isVertical   = isset ($vars ['isVertical']) ? $vars ['isVertical'] : false;
        $this->justified    = isset ($vars ['justified']) ? $vars ['justified'] : false;
    }
    
    /**
     * 
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::render()
     */
    public function render ($display = false) {
        
        $this->setAttrs(array ("role", "group"));
        
        if ($this->isVertical == true) {
            $this->setType($this->getType() . "-vertical");
        }
        
        if (!empty($this->size)) {
            $this->setCustomClass("btn-group-" . $this->size);
        }
        
        if ($this->justified == true) {
            $this->setCustomClass("btn-group-justified");
        }
        
        // 如果 btn-group 有設顏色, 底下的 btn 都要加顏色
        // @todo 試一下是 btn-group 有顏色就好還是底下都有
        if (!empty($this->colorSet) && $this->colorSet != "default") {
            foreach ($this->innerElements as &$ele) {
                if ($ele instanceof Typography && $this->colorSet != $ele->getColorSet()) {
                    $ele->setColorSet($this->colorSet);
                }
            }
        }
        
        parent::render();
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * @desc 按鈕大小, 可輸入 1~5, 數字愈大按鈕愈大 [xs|sm|lg]
     * {@inheritDoc}
     * @see \model\bootstrap\basic\Typography::setSize()
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
                //                 $this->size = "miner";
                $this->size = ""; // preserved.
                break;
            case 2:
                $this->size = "xs";
                break;
            case 3:
                $this->size = "sm";
                break;
            case 4:
                $this->size = "";
                break;
            case 5:
                $this->size = "lg";
                break;
            default:
                $this->size = $size;
                
        }
        
        return $this;
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
    public function setIsVertical($isVertical)
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
