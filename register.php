<?php
$open = true;
require 'lib/site.inc.php';
$view = new BT\RegisterView($site);


// empty response
$response = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head('register.css'); ?>
</head>

<body>
<div class="login">
    <?php
    echo $view->header();

    if ($response != null && $response->success) {
        echo "Hi " . $_POST["name"] . " (" . $_POST["email"] . "), thanks for submitting the form!";
    } else {
        echo $view->presentForm();
    }
    echo $view->footer();
    ?>
</div>

</body>
</html>