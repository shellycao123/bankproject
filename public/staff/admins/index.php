<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/27/2018
 * Time: 12:16 AM
 */
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Administrator Management';
include SHARED_PATH . '/staff_header.php';

$admins = get_all_admins();
?>
<div id = 'content'>
    <div><h1> Administrators</h1></div>
    <div class = 'actions'><a href =<?= url_for("/staff/admins/new.php") ?>> Create New Administrator</a></div>
    <div>
        <table class = 'list'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php
            while( $admin = mysqli_fetch_assoc($admins)){?>
                <tr>
                <td><?= h($admin['id']);?></td>
                <td><?= h($admin['first_name']);?></td>
                <td><?= h($admin['last_name']);?></td>
                <td><?= h($admin['username']);?></td>
                <td><?= h($admin['email']);?></td>
                <td><a href = 'show.php?id=<?= h(u($admin['id']));?>'>View</a></td>
                <td><a href = 'edit.php?id=<?= h(u($admin['id']));?>'>Edit</a></td>
                <td><a href = 'delete.php?id=<?= h(u($admin['id']));?>'>Delete</a></td>
                </tr>
            <?php } ?>

        </table>
    </div>

</div>

<?php
include SHARED_PATH . '/staff_footer.php';
?>
