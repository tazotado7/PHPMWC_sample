<?php

$homepage = URL;
$register = $homepage . 'users/register';
$loginpage = URL . 'users/login';

// if allready is authorized redirect to profile
if (empty($_SESSION['user'])) {
    header("Location: " . $loginpage);
    exit();
}

header('Content-Type: application/json');
echo json_encode($_SERVER,JSON_PRETTY_PRINT);
?>



<?php include(PAGES.'/users/inc/header.php');  ?>


<?php include(PAGES.'/users/inc/footer.php');  ?>