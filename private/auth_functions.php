<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Renerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];

      return true;
  }

  function log_out_admin(){
    unset($_SESSION['admin_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);


  }
  function is_logged_in(){
    //store id in the session, more convenient for looking up in the db
    return isset($_SESSION['admin_id']);
  }

  function required_login(){
    if(!is_logged_in()){
      redirect_to(url_for('/staff/login.php'));
    }
  }

?>
