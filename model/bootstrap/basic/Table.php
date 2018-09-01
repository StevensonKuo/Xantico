<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;
use think\debug\Html;

class Table extends Typography 
{
    protected $headers = array ();
    protected $cells = array ();
    protected $isStriped; // boolean 是否有條紋
    protected $isBordered; // boolean 是否有框
    protected $isCondensed; // boolean 是否為窄間距
    protected $withHoverEffect; // boolean
    
    /**
     * 建構子
     * @param array $vars
     * @return \model\Bootstrap\Basic\Table
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("table:table", $vars, $attr);
        
        $this->type     = "single";
        $this->headers  = array_key_exists("headers", $vars) ? $vars ['headers'] : array();
        $this->cells    = array_key_exists("cells", $vars) ? $vars ['cells'] : array();
        $this->isBordered = array_key_exists("isBordered", $vars) ? $vars ['isBordered'] : false;
        $this->isStriped = array_key_exists("isStriped", $vars) ? $vars ['isStriped'] : false;
        $this->isCondensed = array_key_exists("isCondensed", $vars) ? $vars ['isCondensed'] : false;
        $this->withHoverEffect = array_key_exists("withHoverEffect", $vars) ? $vars ['withHoverEffect'] : false;
    }

    /**
     * @desc 渲染
     * @param string $display
     * @return unknown
     */
    public function render ($display = false) {
        $jQuery = "";
        if ($this->isStriped == true) {
            $this->setCustomClass("table-striped");
        }
        if ($this->isBordered == true) {
            $this->setCustomClass("table-bordered");
        }
        if ($this->isCondensed == true) {
            $this->setCustomClass("table-condensed");
        }
        if ($this->withHoverEffect == true) {
            $this->setCustomClass("table-hover");
        }
        
        if ($this->headers) {
            $tableHead = new HtmlTag("thead");
            $tr = new HtmlTag("tr");

            $colspanToken = 0;
            foreach ($this->headers as $hd) {
                $hClass = array ();
                if (is_array($hd)) {
                    if (isset($hd ['center']) && $hd ['center'] == true) $hClass [] = "center";
                    if (isset($hd ['width'])) $hClass [] = "hidden-" . $hd ['width'];
                    $text = isset($hd ['text']) ? $hd ['text'] . "" : "";
                } else {
                    $text = $hd . "";
                }
                
                if ($colspanToken <= 0) {
                    $th = new HtmlTag("th");
                    $th->setCustomClass($hClass);
                    if (isset($hd ['nowrap']) && $hd ['nowrap'] == true) {
                        $th->setAttrs(array ("nowrap" => "nowrap"));
                    }
                    if (isset($hd ['colspan']) && $hd ['colspan'] > 0) {
                        $th->setAttrs(array ("colspan" => $hd ['colspan']));
                        $colspanToken = $hd ['colspan'];
                    }
                        
                    if ($text instanceof HtmlTag && method_exists($text, "render")) {
                        $th->setInnerElements($text);
                    } else {
                        $th->setInnerText($text);
                    }
                }
                
                $tr->setInnerElements($th);
                unset ($th);
                $colspanToken--;
            }
            
            $tableHead->setInnerElements($tr);
            unset ($tr);
        }
        
        if (!empty($this->cells)) {
            $tableBody = new HtmlTag("tbody");
            $rowspanToken = 0;
            $rowspanKey = null;
            $html = "";
            foreach ($this->cells as $trkey => $cell) {
                $tr = new HtmlTag("tr");
                $colspanToken = 0;
                foreach ($cell as $tdkey => $cl) {
                    $cClass = array ();
                    if (is_array($cl)) {
                        if (isset($cl ['center']) && $cl ['center'] == true) $cClass [] = "center";
                        $text = isset ($cl ['text']) ? $cl ['text'] . "" : "";
                    } else {
                        $text = $cl . "";
                    }
                    
                    $td = new HtmlTag("td");
                    $td->setCustomClass($cClass);
                    
                    if (isset($cl ['width'])) {
                        $td->setAttrs(array ("width" => $cl ['width']));
                    }
                    if (isset($cl ['nowrap']) && $cl ['nowrap'] == true) {
                        $td->setAttrs(array ("nowrap" => "nowrap"));
                    }
                    if (isset($cl ['colspan']) && $cl ['colspan'] > 0) {
                        $td->setAttrs(array ("colspan" => $cl ['colspan']));
                    }
                    if (isset($cl ['rowspan']) && $cl ['rowspan'] > 0) {
                        $td->setAttrs(array ("rowspan" => $cl ['rowspan']));
                    }
                    
                    if ($text instanceof HtmlTag && method_exists($text, "render")) {
                        $td->setInnerElements($text);
                        $jQuery .= $text->getJQuery() . "\n";
                    } else {
                        $td->setInnerText($text);
                    }
                    $tr->setInnerElements($td);
                    unset ($td);
                }
                
                $rowspanToken--;
                $tableBody->setInnerElements($tr);
                unset ($tr);
            } // end of each cell.
            
        }
        
        $this->setInnerElements(array($tableHead, $tableBody));
        
        parent::render();
        
        $this->jQuery = $jQuery;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
        
    }
    
    /**
     * @param Ambigous <multitype:, unknown> $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
        
    /**
     * @param field_type $cells
     */
    public function setCells($cells)
    {
        $this->cells = $cells;
        return $this;
    }
    
    /**
     * @param field_type $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }
    
    /**
     * @return the $isStriped
     */
    public function getIsStriped()
    {
        return $this->isStriped;
    }

    /**
     * @param field_type $isStriped
     */
    public function setIsStriped($isStriped = true)
    {
        $this->isStriped = $isStriped;
        return $this;
    }
    
    /**
     * @return the $isBordered
     */
    public function getIsBordered()
    {
        return $this->isBordered;
    }

    /**
     * @param field_type $isBordered
     */
    public function setIsBordered($isBordered = true) 
    {
        $this->isBordered = $isBordered;
        return $this;
    }
    
    /**
     * @return the $isCondensed
     */
    public function getIsCondensed()
    {
        return $this->isCondensed;
    }

    /**
     * @param field_type $isCondensed
     */
    public function setIsCondensed($isCondensed = true)
    {
        $this->isCondensed = $isCondensed;
        return $this;
    }
    
    /**
     * @return the $withHoverEffect
     */
    public function getWithHoverEffect()
    {
        return $this->withHoverEffect;
    }

    /**
     * @param Ambigous <boolean, array> $withHoverEffect
     */
    public function setWithHoverEffect($withHoverEffect = true)
    {
        $this->withHoverEffect = $withHoverEffect;
        return $this;
    }

    
}

/**
 * @desc table 用的 cell 項目物件
 * @author Stevenson Kuo
 *
 */
class Cellet {
    var $text; // string
    var $center; // boolean
    var $width; // int/string
    var $nowrap; // boolean
    var $colspan; // int
    var $rowspan; // int
    
    public function __construct($text = "", $center = false, $width = "", $nowrap = false, $colspan = 0, $rowspan = 0) {
        $this->text = $text;
        $this->center = $center;
        $this->width = $width;
        $this->nowrap = $nowrap;
        $this->colspan = $colspan;
        $this->rowspan = $rowspan;
        
    }
}

