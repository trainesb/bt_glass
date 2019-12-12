<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\ProductView($site);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('product.css'); ?>
</head>

<body>
<div class="product">
    <?php echo $view->header(); ?>


    <div class="product-display">
        <?php echo $view->presentName(); ?>
        <div class="product-col">
            <?php echo $view->presentSlide(); ?>
        </div>
        <div class="product-col">
        <?php echo $view->presentProduct(); ?>
        </div>
    </div>

    <?php echo $view->footer(); ?>

</div>

</body>
</html>
