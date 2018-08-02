<?php
namespace app\admin\model\bootstrap\hplus;

use think\debug\Html;

class Button extends \app\admin\model\bootstrap\basic\Button
{
    private $app; // 特殊按鈕 3D(dim), dim-large, circle, round
    
    /**
     * generate HTML.
     * @param string $display
     * @return string
     */
    function render ($display = false) {
        $jQuery = "";
        $class = array ();
        if (preg_match("/dim/", $this->app))$class [] = "dim"; // dim, dim-large
        elseif ($this->app)                 $class [] = "btn-" . $this->app; // circle, round.
        
        $this->setCustomClass($class);
        
        parent::render();
        
        $this->jQuery .= $jQuery;
        
        if ($display) {
            echo $this->html;
        } else {
            return $this->html;
        }
    }
    
    /**
     * 按鈕大小
     * 可輸入 1~5, 數字愈大按鈕愈大, Hplus 沒有 miner 大小的按鈕
     * @param string $size
     */
    public function setSize($size)
    {
        switch ($size) {
            case 1:
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
     * @return the $app
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * @desc [dim|dim-large|circle|round]
     * @param Ambigous <unknown, string, \app\admin\model\bootstrap\basic\Icon> $app
     */
    public function setApp($app)
    {
        $this->app = $app;
        return $this;
    }
    
    


}
