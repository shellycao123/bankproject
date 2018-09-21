<?php

require_once('../../../private/initialize.php');
required_login();
$page_title = 'Create New Administrator';
include SHARED_PATH . '/staff_header.php';

$admin = [];
$admin['id'] = $_POST['id']?? "";
$admin['first_name'] = $_POST['first_name']?? "";
$admin['last_name'] = $_POST['last_name']?? "";
$admin['username'] = $_POST['username']?? "";
$admin['hashed_password'] = $_POST['hashed_password']?? "";
$admin['email'] = $_POST['email']?? "";
$admin['rep_password'] = $_POST['rep_password']?? "";

//if the value has been sent by post
if(is_post_request()){
    $result = insert_admin($admin);
    if($result !== true){
        echo display_errors($result);
    }
    else{

        $_SESSION['status'] = "New administrator has been created successfully";
        $id = mysqli_insert_id($db);
        redirect_to(url_for('/staff/admins/show.php?id=' . $id));
    }
}


?>
<div id = 'content'>
    <div><a class = 'back-list' href = <?= url_for('index.php')?>>&laquo;Back to List</a></div>

    <div><h1>Create New Administrator</h1></div>

    <div>
        <form action = <?= url_for('/staff/admins/new.php')?> method = 'post'>
            <dl>
                <dt>First Name</dt>
                <dd><input type = 'text' name = 'first_name' value=<?= h($admin['first_name']);?>></dd>
            </dl>
            <dl>
                <dt>Last Name</dt>
                <dd><input type = 'text' name = 'last_name' value=<?= h($admin['last_name']);?>></dd>
            </dl>
            <dl>
                <dt>Username</dt>
                <dd><input type = 'text' name = 'username' value=<?= h($admin['username']);?>></dd>
            </dl>
            <dl>
                <dt>Email</dt>
                <dd><input type = 'text' name = 'email' value=<?= h($admin['email']);?>></dd>
            </dl>
            <dl>
                <dt>Password</dt>
                <dd><input type = 'password' name = 'hashed_password' value=""></dd>
            </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type = 'password' name = 'rep_password' value=""></dd>
            </dl>

        <div id="operations">
            <input type = 'submit' name = 'submit' value ='Create New Admin'>
        </div>
        </form>
    </div>
</div>


<?php
include SHARED_PATH . '/staff_footer.php';
?>
