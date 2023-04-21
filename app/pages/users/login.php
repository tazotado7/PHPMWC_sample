<?php

$homepage = URL;
$profilepage = URL . 'users/profile';

 // if allready is authorized redirect to profile
if (!empty($_SESSION['user'])) {
    header("Location: " . $profilepage);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
  include(PAGES.'/users/func/auth.php');
  new login_auth();
  exit();
}

?>

<?php include(PAGES.'/users/inc/header.php');  ?>
<link href="<?php echo $homepage;  ?>/css/style.css" rel="stylesheet" />


<div class="container">
<div class="row">
<main class="form-signin w-100 h-100 m-auto d-flex justify-content-center">
  <form method="POST" > 
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <h4><?php if(isset($_SESSION['login_error'])){echo $_SESSION['login_error']; unset($_SESSION['login_error']);} ?></h4>
    <div class="form-floating">
      <input type="text" class="form-control" id="login_username" name="login_username" placeholder="name@example.com">
      <label for="login_username">Email or username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="login_Password" name="login_Password" placeholder="Password">
      <label for="login_Password">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2022</p>
  </form>
</main>
</div>


<?php include(PAGES.'/users/inc/footer.php');  ?>