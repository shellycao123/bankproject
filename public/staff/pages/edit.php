<?php
require_once '../../../private/initialize.php';
required_login();
$page_title = 'Edit Page';
include SHARED_PATH.'/staff_header.php';

if(!isset($_GET['id'])){
    redirect_to(url_for('/staff/pages/index.php'));
}

$page = [];
$page['id'] = $_GET['id'];

if(is_post_request()){
    $page['menu_name']= $_POST['menu_name'];
    $page['visible'] = $_POST['visible'];
    $page['position'] = $_POST['position'];
    $page['subject_id'] = $_POST['subject_id'];
    $page['content'] = $_POST['content'];


    $result = update_page($page);

    if($result === true) {
        $_SESSION['status'] = 'The page has been edited successfully.';
        redirect_to(url_for('/staff/pages/show.php?id=') . u($page['id']));
    }
    else{
        echo display_errors($result);
    }
}
else{
    $page_db = find_page_by_id(($page['id']));
    $page['menu_name'] = $page_db['menu_name'];
    $page['visible'] = $page_db['visible'];
    $page['position'] = $page_db['position'];
    $page['subject_id'] = $page_db['subject_id'];
    $page['content'] = $page_db['content'];
}


$count = count_page_of_same_subject_id($page['subject_id']);


?>

<div id = 'content'>
    <a class = 'back-list' href = <?= url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))) ?>> &laquo;Back to list</a>
    <form method = 'post' action = <?= url_for('/staff/pages/edit.php?id=' . h(u($page['id'])));?>>
    <div class = 'page edit'>
        <h1>Edit the page</h1>
        <form method = 'post' action = <?= url_for('/staff/pages/edit.php?id=' . u($page['id']));?>>
        <dl>
                <dt>Menu Name</dt>
                <dd>
                    <input type = 'text' name="menu_name" value = '<?= $page['menu_name'];?>'>
                </dd>
            </dl>

            <dl>
                <dt>Subject</dt>
                <dd>
                    <select name = 'subject_id'>
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
                    </select>
                </dd>

            </dl>
            <dl>
                <dt> Position</dt>
                <dd>
                    <select name = "position">
                        <?php
                        for($i = 1; $i <= $count; $i++){
                            echo '<option value = '. $i;
                            if($i == $page['position']){
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
                    <input type = 'checkbox' name = 'visible' value = '1' <?php if($page['visible'] == 1){echo 'checked';}?> >
                </dd>
            </dl>

            <dl>
                <dt>Content</dt>
                <dd>
                   <textarea name = "content" rows = '10' cols = '60' ><?= $page['content'];?>
                   </textarea>
                </dd>
            </dl>

            <div id = 'operations'>
                <!-- value of submit input is what is displayed on the page, it does not need a name, the system will give
                it a name "submit"-->
                <input type = 'submit' value = 'Edit Page'>
            </div>
        </form>
    </div>
    </div>

</div>

<?php include SHARED_PATH . '/staff_footer.php';
