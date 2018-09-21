<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/16/2018
 * Time: 2:19 AM
 */
require_once('../../../private/initialize.php');
required_login();
$page_title = 'Create Subject';
require SHARED_PATH.'/staff_header.php';

$subject = [];
$subject['menu_name'] = '';
$subject['position'] = '';
$subject['visible'] = '';


$result = find_all_subjects([]);
$subject_count = mysqli_num_rows($result) + 1;
mysqli_free_result($result);

if(is_post_request()){
    $subject['menu_name']= $_POST['menu_name'];
    $subject['visible'] = $_POST['visible'];
    $subject['position']= $_POST['position'];

    $result = insert_subject($subject);
    if($result === true){
        $_SESSION['status'] = 'The new subject has been created successfully';
        $new_id = mysqli_insert_id($db);
        if($subject['position'] != $subject_count){
            move_subject($subject_count, $subject['position'], $new_id);
        }
        redirect_to(url_for('/staff/subjects/show.php?id=' . $new_id));
    }
    else{
        $errors = $result;
        echo display_errors($errors);
    }
}
else{

}





?>

<div id = 'content'>

    <a class = 'back-list' href = <?= url_for('/staff/subjects/index.php')?>> &laquo;Back to list</a>

    <div class = 'subject new'>
        <h1>Create Subject</h1>
        <form action = '<?= url_for('/staff/subjects/new.php')?>' method = "post">

            <dl>
                <dt>Menu Name</dt>
                <dd>
                <input type = 'text' name="menu_name" value = <?= $subject['menu_name']; ?>>
                </dd>
            </dl>

            <dl>
                <dt> Position</dt>
                <dd>
                    <select name = "position">
                        <?php
                        for($i = 1; $i<=$subject_count; $i++){
                            echo '<option value = ' . $i;
                            if($subject_count ==  $i){
                                echo ' selected';
                            }
                            echo '>' . $i . '</option>';
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
                <input type = 'submit' value = 'Create Subjects'>
            </div>
        </form>
    </div>
</div>

<?php require SHARED_PATH.'/staff_footer.php';