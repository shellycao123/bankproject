<?php
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Edit Administrator';
include SHARED_PATH . '/staff_header.php';
$admin =[];
//when first open, get the id by get method
$id = $_GET['id']?? 1;
$admin = find_admin_by_id($id);

if(is_post_request()){
    $admin['id'] = $id;
    $admin['first_name'] = $_POST['first_name']?? "";
    $admin['last_name'] = $_POST['last_name']?? "";
    $admin['username'] = $_POST['username']?? "";
    $admin['hashed_password'] = $_POST['hashed_password']?? "";
    $admin['email'] = $_POST['email']?? "";
    $admin['rep_password'] = $_POST['rep_password']?? "";
    $result = update_admin($admin);
    if($result){
        $_SESSION['status'] = "The administrator info has been updated successfully.";
        redirect_to(url_for('/staff/admins/show.php?id=' . $id));
    }

}

?>

<div id = 'content'>
    <div><a class = 'back-list' href = <?= url_for('/staff/admins/index.php?id=' . $id)?>>&laquo;Back to List</a></div>

    <div><h1>Edit Administrator</h1></div>

    <div>
        <form method = 'post' action = <?= url_for('/staff/admins/edit.php?id=' . u($id))?> >
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
            <dd><input type = 'password' name = 'hashed_password'></dd>
        </dl>
            <dl>
                <dt>Confirm Password</dt>
                <dd><input type = 'password' name = 'rep_password' value=""></dd>
            </dl>

        <div id="operations">
            <input type = 'submit' name = 'submit' value ='Update Admin'>
        </div>
        </form>
    </div>

</div>

<?php
include SHARED_PATH . '/staff_footer.php';
?>
