<?php
require 'controller/BootstrapController.php';
require 'view/BootstrapView.php';
require 'view/BootstrapFormView.php';
require 'model/bootstrap/Xantico.php';
require 'model/bootstrap/iCaption.php';
require 'model/bootstrap/HtmlTag.php';
require 'model/bootstrap/basic/Typography.php';
require 'model/bootstrap/basic/Jumbotron.php';
require 'model/bootstrap/basic/Button.php';
require 'model/bootstrap/basic/Table.php';
require 'model/bootstrap/basic/Image.php';
require 'model/bootstrap/basic/Badge.php';
require 'model/bootstrap/basic/Label.php';
require 'model/bootstrap/basic/Nav.php';
require 'model/bootstrap/basic/Navbar.php';
require 'model/bootstrap/basic/Dropdown.php';
require 'model/bootstrap/basic/Alert.php';
require 'model/bootstrap/basic/ListGroup.php';
require 'model/bootstrap/basic/Panel.php';
require 'model/bootstrap/basic/ProgressBar.php';
require 'model/bootstrap/basic/Icon.php';
require 'model/bootstrap/basic/Carousel.php';
require 'model/bootstrap/basic/Form.php';
require 'model/bootstrap/basic/iRequiredInput.php';
require 'model/bootstrap/basic/Input.php';
require 'model/bootstrap/basic/Select.php';
require 'model/bootstrap/basic/Textarea.php';

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

