<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\TopCategoryView($site);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('topcategory.css'); ?>
</head>

<body>
<div class="staff">
    <?php
    echo $view->header();
    echo $view->presentSubCategories();
    echo $view->footer();
    ?>

</div>

</body>
</html>
