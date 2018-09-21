<?php
 require_once "../../private/initialize.php";
 required_login();
$page_title = 'Staff Menu';
 include SHARED_PATH."/staff_header.php";
 ?>


    <div id = "content">
        <div id="main-menu">
            <h2>Main Menu</h2>
            <ul>
                <li><a href = <?php echo url_for("/staff/subjects/index.php")?>>Subjects</a></li>
                <li><a href = <?= url_for("/staff/admins/index.php");?>> Administrators</a></li>
            </ul>
        </div>
    </div>

<?php include SHARED_PATH.'/staff_footer.php';?>