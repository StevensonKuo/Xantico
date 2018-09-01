<?php
namespace controller;

use view\BootstrapView;
use view\BootstrapFormView;

class BootstrapController {
    
    public function main () {
        $page = $_REQUEST ['page'];
        if (strtolower($page) == "form") {
            $view = new BootstrapFormView();
        } else {
            $view = new BootstrapView();
        }

        $view->fetchView();
    }
}