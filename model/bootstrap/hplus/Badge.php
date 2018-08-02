<?php
namespace app\admin\model\bootstrap\hplus;


class Badge extends \app\admin\model\bootstrap\basic\Badge
{
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $html = parent::render();
        
        if ($display) {
            echo $html;
        } else {
            return $html;
        }
    }
    
}



