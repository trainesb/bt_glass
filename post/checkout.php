<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';
$controller = new BT\CheckoutController($site, $_POST, $_SESSION);

echo $controller->getResult();