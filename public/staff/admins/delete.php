<?php
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Delete Administrator';
include SHARED_PATH . '/staff_header.php';

$id = $_GET['id']??2;

if(is_post_request()){
    $result = delete_admin($id);
    $_SESSION['status'] = "The admin has been deleted sucessfully. ";
    redirect_to(url_for('/staff/admins/index.php'));
}
?>
<div id = 'content'>
    <div class = "back-list"><a href="<?= url_for('/staff/admins/index.php')?>">&laquo;Back to List</a></div>


<div><h1>Delete Admin: <?php
        $admin = find_admin_by_id($id);
        echo $admin['username'];
        ?></h1></div>

<p>Are you sure you want to delete the admin?</p>
<p><?php        echo $admin['username']; ?></p>

    <div>
        <form method = 'post' action = <?= url_for('/staff/admins/delete.php?id=' . $id) ?>>
            <input type = 'submit' value ='Delete Admin'>
        </form>
    </div>

</div>

<?php
include SHARED_PATH . '/staff_footer.php';
?>
