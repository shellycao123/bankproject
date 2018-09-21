
<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/15/2018
 * Time: 11:16 PM
 */
require_once('../../../private/initialize.php');
required_login();
require SHARED_PATH.'/staff_header.php';
$id = $_GET['id']?? '1';

//get the page from the database by its id
$page = find_page_by_id($id);
?>

<div id = "content">
    <a class = 'back-list' href = <?= url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))) ?>> &laquo;Back to list</a>

    <div class = 'page show'>
        <h1>Page Name: <?= $page['menu_name'];?></h1>

        <div class = "attribute">
            <dl>
                <dt>Menu name</dt>
                <dd><?= $page['menu_name'];?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?= $page['position'];?></dd><br>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?= $page['visible']==1?'True':'False';?></dd><br>
            </dl>
            <dl>
                <dt>Subject </dt>
                <dd><?php
                    $id = $page['subject_id'];
                    $subject = find_subject_by_id($id);
                    $name = $subject['menu_name'];
                    echo $name;
                    ?> </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <p><?= $page['content'];?></p>
                </dd>
            </dl>
        </div>
    </div>

</div>


<?php require SHARED_PATH.'/staff_footer.php';?>