<?php
require '../lib/site.inc.php';

$controller = new BT\UsersController($site, $user, $_POST);
header("location: " . $controller->getRedirect());