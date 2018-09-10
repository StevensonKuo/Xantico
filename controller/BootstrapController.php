<?php
namespace controller;

require 'view/BootstrapView.php';

use view\BootstrapView;

class BootstrapController {
    
    public function main () {
        $page = isset($_REQUEST ['page']) ? strtolower($_REQUEST ['page']) : "default";
        $view = new BootstrapView();

        if (method_exists($view, $page."View")) {
            $view->{$page."View"}();
        } else {
            throw \Exception("View not found.");
        }
    }
}