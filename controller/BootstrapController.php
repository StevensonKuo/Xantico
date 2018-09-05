<?php
namespace controller;

require 'view/BootstrapView.php';
require 'view/BootstrapFormView.php';

use view\BootstrapView;
use view\BootstrapFormView;

class BootstrapController {
    
    public function main () {
        $page = isset($_REQUEST ['page']) ? $_REQUEST ['page'] : "";
        if (strtolower($page) == "form") {
            $view = new BootstrapFormView();
        } else {
            $view = new BootstrapView();
        }

        $view->fetchView();
    }
}