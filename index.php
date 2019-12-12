<?php

//header("location: ./top-category.php?4");

$open = true;
require 'lib/site.inc.php';
$view = new BT\HomeView($site);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('home.css'); ?>
</head>

<body>
<div class="index">

    <?php
    echo $view->header();

    echo $view->present();

    echo $view->footer();
    ?>

</div>

</body>
</html>