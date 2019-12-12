<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new BT\TopCategoryController($site, $_POST);

echo json_encode($_POST['sub_id']);
