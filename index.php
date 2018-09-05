<?php
include 'requires.php';
require 'controller/BootstrapController.php';

use controller\BootstrapController;

ob_start('ob_gzhandler');

header ("X-Frame-Options: SameOrigin"); // X-Frame-Scripting issue solution
header ("Content-Type: text/html; charset=utf-8");

/**
 * load page controller.
 */

$controller = new BootstrapController();

$controller->main();
ob_end_flush();

