<?php
require '../lib/site.inc.php';

$controller = new BT\UserController($site, $user, $_POST);
echo $controller->getResult();