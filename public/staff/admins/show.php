<?php
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Administrator Management';
include SHARED_PATH . '/staff_header.php';
$id = $_GET['id']??3;
$admin = find_admin_by_id($id);

?>

<div id = 'content'>
    <div><a class = 'back-list' href = <?= url_for('/staff/admins/index.php?id=' . $id)?>>&laquo;Back to List</a></div>

    <div><h1>Admin: <?=  h($admin['username']);?></h1></div>

    <div>
        <dl>
            <dt>First Name: </dt>
            <dd><?=h($admin['first_name']);?></dd>
        </dl>
        <dl>
            <dt>Last Name: </dt>
            <dd><?=h($admin['last_name']);?></dd>
        </dl>
        <dl>
            <dt>ID: </dt>
            <dd><?=h($admin['id']);?></dd>
        </dl>
        <dl>
            <dt>Username: </dt>
            <dd><?=h($admin['username']);?></dd>
        </dl>
        <dl>
            <dt>Email: </dt>
            <dd><?=h($admin['email']);?></dd>
        </dl>
    </div>

</div>







<?php
include SHARED_PATH . '/staff_footer.php';
?>