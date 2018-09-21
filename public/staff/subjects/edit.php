<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/16/2018
 * Time: 2:19 AM
 */
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Edit Subject';
require SHARED_PATH.'/staff_header.php';

$subject = [];
$subject['menu_name'] = '';
$subject['position'] = '';
$subject['visible'] = '';


if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];

//display the post values if it has been used once on this page, redirect to the list if they are not
if( is_post_request()){
    //find the previous position for updating
    $subject = find_subject_by_id($id);

    //receive value from post method
    $subject['menu_name'] = $_POST['menu_name'];
    $subject['old'] = $subject['position'];
    $subject['position'] = $_POST['position'];
    $subject['visible'] = $_POST['visible'];


    //edit the
    $result = edit_subject($subject);
    if($result ===true){
        $_SESSION['status'] = 'The subject has been edited successfully';
        if($subject['position'] != $subject['old']){
            move_subject($subject['old'],$subject['position'], $subject['id']);
        }
        redirect_to(url_for('/staff/subjects/show.php?id=' . $id));
    }
    else{
        $errors = $result;
        echo display_errors($errors);
        //var_dump($errors);
    }
}
else{
    $subject = find_subject_by_id($id);
}

$subject_set = find_all_subjects([]);
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);
?>

    <div id = 'content'>

        <a class = 'back-list' href = <?= url_for('/staff/subjects/index.php')?>> &laquo;Back to list</a>

        <div class = 'subject new'>
            <h1>Edit Subject</h1>
            <form action = '<?= url_for('/staff/subjects/edit.php?id=') . u($subject['id']);?>' method = "post">
                <dl>
                    <dt>Menu Name</dt>
                    <dd>
                        <input type = 'text' name="menu_name" value = "<?= $subject['menu_name'];?>">
                    </dd>
                </dl>

                <dl>
                    <dt> Position</dt>
                    <dd>
                        <select name = "position">
                            <?php for($i=1;$i<=$subject_count;$i++){
                                echo '<option value = '. "'$i'";
                                if($subject['position'] == $i){
                                    echo 'selected';
                                }
                                echo ">$i</option>";
                            }
                           ?>
                        </select>
                    </dd>
                </dl>
                <dl>
                    <dt>Visible</dt>
                    <dd>
                        <input type = 'hidden' name = 'visible' value = '0'>
                        <input type = 'checkbox' name = 'visible' value = '1' <?php if($subject['visible'] == 1){echo 'checked';}?>>
                    </dd>
                </dl>

                <div id = 'operations'>
                    <!-- value of submit input is what is displayed on the page, it does not need a name, the system will give
                    it a name "submit"-->
                    <input type = 'submit' value = 'Edit Subjects'>
                </div>
            </form>
        </div>
    </div>

<?php require SHARED_PATH.'/staff_footer.php';?>