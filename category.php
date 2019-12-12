<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\CategoryView($site);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('category.css'); ?>
</head>

<body>
<div class="staff">
    <?php
    echo $view->header();
    echo $view->present();
    echo $view->footer();
    ?>

</div>

</body>
</html>
