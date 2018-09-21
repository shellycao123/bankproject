<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  //validation
    if(is_blank($username)){
        $errors[] = "Username cannot be blank. ";
    }
    if(is_blank($password)){
        $errors[] = "Password cannot be blank. ";
    }
    //if there were no input errors, validate the identity of the user
    if(empty($errors)){
        //find the admin in the db
        $result = find_admin_by_username($username);
        $admin = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $login_error = 'Log in failed. ';
        if($admin){
            //if the admin is found
            if(password_verify($password,$admin['hashed_password'])){
                //if the password is correct
                log_in_admin($admin);
                redirect_to(url_for('/staff/index.php'));
            }
            else{
                //if password is incorrect
                $errors[] = $login_error;
            }
        }
        else{
            //if the admin is not found in the db
            $errors[] = $login_error;
        }
    }

}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <h1>Log in</h1>

  <?php echo display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br />
    <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
    Password:<br />
    <input type="password" name="password" value="" /><br />
    <input type="submit" name="submit" value="Submit"  />
  </form>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
