<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\ReceiptView($site, $_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('cart.css'); ?>
</head>

<body>
<div class="cart">
    <?php
    echo $view->header();
    echo $view->present();
    echo $view->footer();
    ?>

</div>

</body>
</html>
