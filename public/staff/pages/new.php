<?php
require_once  '../../../private/initialize.php';
required_login();
$page_title = 'Add Page';
include SHARED_PATH. '/staff_header.php';

$page = [];
$page['menu_name']= '';
$page['visible'] = '';
$page['position'] = '';
$page['subject_id'] = $_GET['id']??'';
$page['content'] = '';
$count = count_page_of_same_subject_id($page['subject_id']) + 1;


if(is_post_request()){
    $page['menu_name']= $_POST['menu_name'];
    $page['visible'] = $_POST['visible'];
    $page['position'] = $_POST['position'];
    $page['subject_id'] = $_POST['subject_id'];
    $page['content'] = $_POST['content'];

    $result = insert_page($page);
    if($result === true) {
        $id = mysqli_insert_id($db);
        if($page['position'] != $count){
            move_page($count, $page['position'], $id);
        }
        $_SESSION['status'] = 'New page has been created successfully.';
        redirect_to(url_for('/staff/pages/show.php?id=' . u($id)));
    }
    else{
        echo display_errors($result);
    }
}

?>

<div id = 'content'>
    <a class = 'back-list' href = <?= url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))) ?>> &laquo;Back to list</a>

    <div class = "page new">
        <h1>Create new page</h1>

        <form action = "<?= url_for("/staff/pages/new.php?id=" . h(u($page['subject_id'])))?>" method = "post">
            <dl>
                <dt>Menu name</dt>
                <dd>
                    <input type = "text" name = "menu_name" value = "<?= h(u($page['menu_name'])); ?>">
                </dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd>
                    <select name = "position" >
                        <?php for( $i =1 ;$i <= $count; $i++){
                            echo '<option value = ' . $i;
                            if($i == $count){
                                echo ' selected';
                            }
                            echo '>' . $i . '</option>';
                        }?>
                    </select>
                </dd>
            </dl>
                <dl>
                <dt> Subject</dt>
                <dd><select name = 'subject_id'>
                    <?php
                    $subjects = find_all_subjects();
                    while ($subject = mysqli_fetch_assoc($subjects)) {
                        echo '<option value = ' . $subject['id'];
                        if($subject['id'] == $page['subject_id']){
                            echo ' selected';
                        }
                        echo '>' . $subject['menu_name'] . '</option>';
                    }
                    mysqli_free_result($subjects);
                    ?>

                    </select></dd>
                </dl>

            <dl>
                <dt>Visible</dt>
                <dd>
                    <input type = 'hidden' name = 'visible' value = '0'>
                    <input type = 'checkbox' name = 'visible' value = '1' <?php if($page['visible'] == 1){ echo 'checked';}?> >
                </dd>
            </dl>
            <dl>
                <dt>Content</dt>
                <dd>
                    <textarea name="content" cols="60" rows="10"><?= $page['content'];?></textarea>
                </dd>

            </dl>

            <div id = 'operations'>
                <input type = 'submit' value = 'Create new page'>
            </div>
        </form>
    </div>

</div>

<?php include SHARED_PATH. '/staff_footer.php';?>
