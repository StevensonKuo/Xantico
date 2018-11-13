<?php
include 'requires.php';
require 'controller/BootstrapController.php';
require 'controller/DevoopsController.php';

use controller\BootstrapController;
use controller\DevoopsController;

ob_start('ob_gzhandler');

header ("X-Frame-Options: SameOrigin"); // X-Frame-Scripting issue solution
header ("Content-Type: text/html; charset=utf-8");

/**
 * load page controller.
 */
$suite = isset($_REQUEST ['suite']) ? strtolower($_REQUEST ['suite']) : "Bootstrap";
$className = "controller\\" . ucfirst($suite) . "Controller";
if (!empty($suite) && class_exists($className)) {
    eval("\$controller = new {$className}();");
} else {
    $controller = new BootstrapController();
}


$controller->main();
ob_end_flush();

