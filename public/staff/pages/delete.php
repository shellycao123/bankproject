<?php
require_once '../../../private/initialize.php';
required_login();

$page_title = 'Delete Page';
include SHARED_PATH . '/staff_header.php';

$page = [];
$page['id'] = $_GET['id']?? 1;
$page = find_page_by_id($page['id']);

if(is_post_request()){

    $result = delete_page($page['id']);
    if($result === true) {
        $_SESSION['status'] = 'The page has been deleted successfully.';
        redirect_to(url_for('/staff/subjects/show.php?id=' . u($page['subject_id'])));
    }
    else{
        echo display_errors($result);
    }
}

else{
}
?>

<div id = 'content'>
    <a class = 'back-list' href = <?= url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))) ?>> &laquo;Back to list</a>


    <div class = 'page delete'>
    <h1>Menu Name: <?= $page['menu_name']?></h1>

    <p>Are you sure you want to delete the page? </p>
    <p><?= $page['menu_name']?></p>

    <form method = 'post' action = <?= 'delete.php?id=' . $page['id'];?> >
        <input type = 'submit' value = 'Delete Page'>
    </form>

</div>
</div>

<?php include SHARED_PATH . '/staff_footer.php';?>
