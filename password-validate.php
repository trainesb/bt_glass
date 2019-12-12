<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\PasswordValidateView($site, $_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('password-validate.php'); ?>
</head>

<body>
<div class="password">

    <?php
    echo $view->header();
    echo $view->passwordForm();
    echo $view->footer();
    ?>

</div>

</body>
</html>