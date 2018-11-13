<?php
namespace controller;

require 'view/DevoopsView.php';

use view\DevoopsView;

class DevoopsController {
    
    public function main () {
        $page = isset($_REQUEST ['page']) ? strtolower($_REQUEST ['page']) : "default";
        $view = new DevoopsView();

        if (method_exists($view, $page."View")) {
            $view->{$page."View"}();
        } else {
            throw new \Exception("View not found: [" . $page . "].");
        }
    }
}