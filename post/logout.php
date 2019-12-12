<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$_SESSION[BT\User::SESSION_NAME] = null;


header("location: ../login.php");