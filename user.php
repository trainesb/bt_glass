<?php
require 'lib/site.inc.php';
$view = new BT\UserView($site);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('user.css'); ?>
</head>

<body>
<div class="user">
    <?php
    echo $view->header();
    echo $view->present();
    echo $view->footer();
    ?>
</div>

</body>
</html>
