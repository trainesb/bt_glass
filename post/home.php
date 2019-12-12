<?php
$open = true;       // Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new BT\TopCategoryController($site, $user, $_POST, $_SESSION);


echo json_encode($_POST['value']);