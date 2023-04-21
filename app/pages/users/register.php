<?php

$homepage = URL;
$register = $homepage . 'users/register';
$profilepage = URL . 'users/profile';

// if allready is authorized redirect to profile
if (!empty($_SESSION['user'])) {
    header("Location: " . $profilepage);
    exit();
}
?>

<?php include(PAGES . '/users/inc/header.php'); ?>
<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }
</style>

<div class="container">
<div class="row">

<main class="form-signin w-100 m-auto">
    <form method="POST" action="<?php echo $auth; ?>">
        <h1 class="h3 mb-3 fw-normal">Register New User</h1>
        <h4>
            <?php echo !empty($_SESSION['register_error']) ? $_SESSION['register_error'] : ''; ?>
        </h4>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="register_username" name="register_username"
                placeholder="name@example.com">
            <label for="register_username">New Email or username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="register_Password_1" name="register_Password_1"
                placeholder="Password">
            <label for="register_Password_1">Password</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="register_Password_2" name="register_Password_2"
                placeholder="Password">
            <label for="register_Password_2">Repaet Password</label>
        </div>
 
        <button class="w-100 btn btn-lg btn-primary" type="submit">Create User</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
    </form>
</main>
</div>


<?php include(PAGES . '/users/inc/footer.php'); ?>