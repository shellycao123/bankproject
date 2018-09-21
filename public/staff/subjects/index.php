<?php
require_once "../../../private/initialize.php";
required_login();
$page_title = 'Subject';
include SHARED_PATH."/staff_header.php";

$subject_set = find_all_subjects();

?>

<div id = "content">
        <h1>Subjects</h1>

        <div class = "actions"><a href = <?= url_for('/staff/subjects/new.php')?> >Create new subject</a></div>
    <div>
        <table  class = "list">
            <tr>
                <th>ID</th>
                <th>Position</th>
                <th>Visible</th>
                <th>Name</th>
                <th>Pages</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php while($subject = mysqli_fetch_assoc($subject_set)){?>
            <tr>
                <td><?=$subject['id'];?></td>
                <td><?=$subject['position'];?></td>
                <td><?php echo ($subject['visible']  == 1 ? 'true': 'false');?></td>
                <td><?=$subject['menu_name'];?></td>
                <td><?= count_page_of_same_subject_id($subject['id']);?></td>
                <td class = "actions"> <a href = <?= url_for("/staff/subjects/show.php?id=").h(u($subject["id"]));?>>View</a></td>
                <td class = "actions"> <a href = <?= url_for("staff/subjects/edit.php?id=") . h(u($subject['id']));?> >Edit</a></td>
                <td class = "actions"> <a href = <?= url_for('/staff/subjects/delete.php?id=').h(u($subject["id"]));?>>Delete</a></td>
            </tr>
            <?php } ?>
        </table>
        <?php mysqli_free_result($subject_set);?>
        </div>
</div>

<?php include SHARED_PATH.'/staff_footer.php';?>