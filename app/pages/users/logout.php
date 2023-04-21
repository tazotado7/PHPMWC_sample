<?php
unset($_SESSION['user']);
$loginpage = URL . 'users/login';
$url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $loginpage;
            header("Location: " . $url);
exit();
?>