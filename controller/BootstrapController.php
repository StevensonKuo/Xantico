<?php
namespace controller;

use view\BootstrapView;

class BootstrapController {
    
    public function main () {
        $view = new BootstrapView();
        $view->fetchView();
    }
}