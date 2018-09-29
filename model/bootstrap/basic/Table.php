<?php
namespace model\bootstrap\basic;

use model\bootstrap\basic\Typography;
use model\bootstrap\HtmlTag;

class Table extends Typography 
{
    protected $headers = array ();
    protected $cells = array ();
    protected $isStriped; // boolean 
    protected $isBordered; // boolean
    protected $isCondensed; // boolean
    protected $withHoverState; // boolean
    protected $isResponsive; // boolean
    
    /**
     * @param array $vars
     * @return \model\Bootstrap\Basic\Table
     */
    public function __construct($vars = array (), $attr = array ())
    {
        parent::__construct("table:table", $vars, $attr);
        
        $this->headers          = isset($vars ["headers"]) ? $vars ['headers'] : array();
        $this->cells            = isset($vars ["cells"]) ? $vars ['cells'] : array();
        $this->isBordered       = isset($vars ["isBordered"]) ? $vars ['isBordered'] : false;
        $this->isStriped        = isset($vars ["isStriped"]) ? $vars ['isStriped'] : false;
        $this->isCondensed      = isset($vars ["isCondensed"]) ? $vars ['isCondensed'] : false;
        $this->withHoverState   = isset($vars ["withHoverEffect"]) ? $vars ['withHoverEffect'] : false;
    }

    /**
     * @param string $display
     * @return unknown
     */
    public function render ($display = false) {
        if ($this->isStriped == true) {
            $this->customClass [] = "table-striped";
        }
        if ($this->isBordered == true) {
            $this->customClass [] = "table-bordered";
        }
        if ($this->isCondensed == true) {
            $this->customClass [] = "table-condensed";
        }
        if ($this->withHoverState == true) {
            $this->customClass [] = "table-hover";
        }
        
        $_innerElements = array ();
        if (!empty($this->caption)) {
            $_caption = new HtmlTag("caption");
            $_caption->setInnerElements($this->caption);
            $_innerElements [] = $_caption;
        }
        
        if (!empty($this->headers)) {
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
                    $th->appendCustomClass($hClass);
                    if (isset($hd ['nowrap']) && $hd ['nowrap'] == true) {
                        $th->appendAttrs(array ("nowrap" => "nowrap"));
                    }
                    if (isset($hd ['colspan']) && $hd ['colspan'] > 0) {
                        $th->appendAttrs(array ("colspan" => $hd ['colspan']));
                        $colspanToken = $hd ['colspan'];
                    }
                        
                    if ($text instanceof HtmlTag && method_exists($text, "render")) {
                        $th->appendInnerElements($text);
                    } else {
                        $th->setInnerText($text);
                    }
                }
                
                $tr->appendInnerElements($th);
                unset ($th);
                $colspanToken--;
            }
            
            $tableHead->appendInnerElements($tr);
            unset ($tr);
            
            $_innerElements [] = $tableHead;
        }
        
        if (!empty($this->cells)) {
            $tableBody = new HtmlTag("tbody");
            $rowspanToken = 0;
            $rowspanKey = null;
            $html = "";
            foreach ($this->cells as $trkey => $cell) {
                $tr = new HtmlTag("tr");
                $colspanToken = 0;
                if (isset ($cell ['context']) && in_array($cell ['context'], self::$contextArr)) {
                    $tr->setCustomClass($cell ['context']);
                }
                if (isset($cell ['isActive']) && $cell ['isActive'] == true) {
                    $tr->appendCustomClass("active");
                }
                if (isset($cell ['td'])) {
                    $cell = $cell ['td'];
                }
                if (!empty($cell)) {
                    foreach ($cell as $tdkey => $cl) {
                        $cClass = array ();
                        if (is_array($cl)) {
                            if (isset($cl ['center']) && $cl ['center'] == true) $cClass [] = "center";
                            $text = isset ($cl ['text']) ? $cl ['text'] . "" : "";
                        } else {
                            $text = $cl . "";
                        }
                        
                        $td = new HtmlTag("td");
                        $td->appendCustomClass($cClass);
                        
                        if (isset($cl ['width'])) {
                            $td->appendAttrs(array ("width" => $cl ['width']));
                        }
                        if (isset($cl ['nowrap']) && $cl ['nowrap'] == true) {
                            $td->appendAttrs(array ("nowrap" => "nowrap"));
                        }
                        if (isset($cl ['colspan']) && $cl ['colspan'] > 0) {
                            $td->appendAttrs(array ("colspan" => $cl ['colspan']));
                        }
                        if (isset($cl ['rowspan']) && $cl ['rowspan'] > 0) {
                            $td->appendAttrs(array ("rowspan" => $cl ['rowspan']));
                        }
                        
                        if ($text instanceof HtmlTag && method_exists($text, "render")) {
                            $td->appendInnerElements($text);
                            $jQuery .= $text->getJQuery() . "\n";
                        } else {
                            $td->setInnerText($text);
                        }
                        $tr->appendInnerElements($td);
                        unset ($td);
                    }
                }
                
                $rowspanToken--;
                $tableBody->appendInnerElements($tr);
                unset ($tr);
            } // end of each cell.
            
            $_innerElements [] = $tableBody;
            
        }
        
        $this->innerElements = $_innerElements;
        // no other inner elements. 
        
        parent::render();
        
        if ($display == true) {
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
        
    public function setHeader($headers)
    {
        $this->headers = $headers;
        return $this;
    }
    
    /**
     * @todo Check TableRow and TableCells
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
    public function getWithHoverState()
    {
        return $this->withHoverState;
    }

    /**
     * @param Ambigous <boolean, array> $withHoverEffect
     */
    public function setWithHoverState($withHoverEffect = true)
    {
        $this->withHoverState = $withHoverEffect;
        return $this;
    }
    
    /**
     * @return the $isResponsive
     */
    public function getIsResponsive()
    {
        return $this->isResponsive;
    }

    /**
     * @param field_type $isResponsive
     */
    public function setIsResponsive($isResponsive = true)
    {
        $this->isResponsive = $isResponsive;
        return $this;
    }
    
    /**
     * @return the $headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @desc alias of getHeaders
     * @return array|unknown
     */
    public function getHeader()
    {
        return $this->headers;
    }
    
    /**
     * @return the $cells
     */
    public function getCells()
    {
        return $this->cells;
    }

    

    
}

