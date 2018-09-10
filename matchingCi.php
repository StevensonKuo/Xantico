#!/usr/bin/php
<?php
// include 'requires.php';
require 'controller/MatchingController.php';
require 'view/MatchingView.php';
require 'libs/ADOdb-master/adodb.inc.php';

use controller\MatchingController;

/** * load page controller. */

$controller = new MatchingController();

$api = isset($argv [1]) ? $argv [1] : null;
if (!empty($api) && method_exists($controller, $api)) {
    $param = isset($argv [2]) ? $argv [2] : null;
	$controller->{"$api"}($param);
} else {
	$controller->main();
}

