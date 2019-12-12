<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\LoginView($site, $_COOKIE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('login.css'); ?>
</head>

<body>
<div class="login">
    <?php
    echo $view->header();
    echo $view->presentLoginForm();
    echo $view->footer();
    ?>
</div>

</body>
</html>