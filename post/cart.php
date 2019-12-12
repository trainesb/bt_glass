<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';
$controller = new BT\CartController($site, $_SESSION, $_GET);

echo $controller->getResult();