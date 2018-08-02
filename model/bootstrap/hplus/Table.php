<?php
namespace app\admin\model\bootstrap\hplus;

class Table extends \app\admin\model\bootstrap\basic\Table
{

    protected $width;
    /**
     * 渲染
     * @param string $display
     * @throws \Exception
     * @return string
     */
    function render ($display = false) {
        $jQuery = "";
        $html = "<table";
        $class [] = "table table-striped table-bordered table-hover";
        $html .= " class=\"" . join (" ", $class) . "\"";
        if ($this->width) $html .= " style=\"width: {$this->width}\"";
        $html .= ">\n";
        
        if ($this->headers) {
            $html .= "<thead>\n";
            $html .= "<tr>";
            $colspanToken = 0;
            foreach ($this->headers as $hd) {
                $hClass [] = isset($hd ['center']) && $hd ['center'] == true ? "center" : "";
                $hClass [] = isset($hd ['width']) ? "hidden-" . $hd ['width'] : "";
                $text = isset($hd ['text']) ? $hd ['text'] : "";
                
                if ($colspanToken <= 0) {
                    $html .= "<th class=\"" . join (" ", $hClass) . "\"" . 
                        (isset($hd ['nowrap']) ? " nowrap=\"nowrap\"" : ""); 
                        if (isset($hd ['colspan']) && $hd ['colspan'] > 0) {
                        $html .= " colspan=\"{$hd ['colspan']}\""; 
                        $colspanToken = $hd ['colspan'];
                    }
                    if (method_exists($text, "render")) {
                        $html .= ">\n" . $text->render() . "</th>";
                    } else {
                        $html .= ">\n{$text}</th>";
                    }
                    
                }
                
                unset ($hClass);
                $colspanToken--;
            }
            $html .= "</tr>\n";
            $html .= "</thead>\n";
        }

        if ($this->cells) {
            $html .= "<tbody>\n";
            $rowspanToken = 0;
            $rowspanKey = null;
            foreach ($this->cells as $trkey => $cell) {
                $html .= "<tr>";
                $colspanToken = 0;
                foreach ($cell as $tdkey => $cl) {
                    if ($colspanToken <= 0 && ($rowspanToken <= 0 && $tdkey !== $rowspanKey)) {
                        $cClass [] = isset($cl ['center']) && $cl ['center'] == true ? "center" : "";
                        $text = isset ($cl ['text']) ? $cl ['text'] : "";
                        $html .= "<td class=\"" . join (" ", $cClass) . "\"" . 
                                    (isset($cl ['nowrap']) ? " nowrap=\"nowrap\"" : "");
                        if (isset($cl ['colspan']) && $cl ['colspan'] > 0) {
                            $html .= " colspan=\"{$cl ['colspan']}\"";
                            $colspanToken = $cl ['colspan'];
                        }
                        if (isset($cell ['rowspan']) && $cell ['rowspan'] > 0) {
                            $html .= " colspan=\"{$cell ['rowspan']}\"";
                            $rowspanToken = $cell ['rowspan'];
                            $rowspanKey = $tdkey;
                        }
                        $html .= (isset($cl ['width']) ? " width=\"{$cl ['width']}\"" : "") . ">";
                        if (method_exists($text, "render")) {
                            $html .= $text->render() . "</td>\n";
                            $jQuery .= $text->getJQuery() . "\n";
                        } else {
                            $html .= $text . "</td>\n";
                        }
                                    
                    }
                    
                    unset ($cClass);
                    $colspanToken--;
                }
                
                $html .= "</tr>\n";
                $rowspanToken--;
            }
            
            $html .= "</tbody>\n";
        }
        
        $html .= "</table>";
        
        $this->html = $html;
        $this->jQuery = $jQuery;
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
        
    }
    
}
