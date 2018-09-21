<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/21/2018
 * Time: 6:04 AM
 */
require_once '../../../private/initialize.php';
required_login();
$page_title = 'Delete Subject';
include SHARED_PATH . '/staff_header.php';

$id = $_GET['id'];
$subject = find_subject_by_id($id);


//if the request is submitted
if(is_post_request()){
    $result  = delete_subject($id);
    if($result === true) {
        $_SESSION['status'] = 'The subject has been deleted successfully';
        $count = count_all_subjects();
        if($subject['position'] != $count + 1){
            move_subject($subject['position'],$count + 1);
        }
        redirect_to(url_for('/staff/subjects/index.php'));
    }
    else{
        echo display_errors($result);
    }
}

?>

<div id = 'content'>
    <a class = 'back-link' href = <?= url_for('/staff/subjects/index.php');?>>
        &laquo;Back to List </a>

    <div class = 'subject delete'>

        <h1>Delete Subject</h1>
        <P>Are you sure you want to delete this subject?</P>
        <p><?= $subject['menu_name'];?></p>

        <form method = 'post' action = '<?= 'delete.php?id=' . u($id);?>'  class = 'actions'>
            <input type = 'submit' value = 'Delete Subject' name = 'submit'>
        </form>




    </div>



</div>




<?php
include SHARED_PATH . '/staff_footer.php';
?>
