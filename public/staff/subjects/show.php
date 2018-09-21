<?php
/**
 * Created by PhpStorm.
 * User: 10563_000
 * Date: 8/15/2018
 * Time: 5:54 AM
 */

$id = $_GET['id'] ?? '1';
require_once("../../../private/initialize.php");
required_login();
require SHARED_PATH . '/staff_header.php';
$subject  = find_subject_by_id($id);
$pages = find_all_pages_by_subject_id($id);
?>

<div id = "content">
    <div class = "actions">
        <a href = <?= 'index.php';?> >&laquo;Back to list</a>
    </div>
    <div class = "subject show">
        <h1> Subject: <?= h($subject['menu_name'])?></h1>

        <div class = 'attributes'>

            <dl>
                <dt>Menu Name:</dt>
                <dd><?= h($subject['menu_name'])?></dd></dl>
            <dl>
                <dt>Position: </dt>
                <dd><?= h($subject['position'])?></dd>
            </dl>
            <dl>
                <dt>Visible: </dt>
                <dd><?php if($subject['visible'] ==1){
                     echo 'True';
                    }
                    else{
                        echo 'False';
                    }?></dd>
            </dl>

            <!--horizontal dividing line in html -->
            <hr>

                <div class = "page listing" >
                    <h2>Pages</h2>
                    <div class = "actions">
                        <a href = <?= url_for("/staff/pages/new.php?id=" . h(u($id)));?>>Create a new page</a>
                    </div>
            <div>
                <table class = "list">
                    <tr>
                        <th>ID</th>
                       <!-- <th>Subject</th> -->
                        <th>Position</th>
                        <th>Visible</th>
                        <th>Name</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <?php while($page = mysqli_fetch_assoc($pages)){;?>
                        <tr>
                            <td><?= h($page['id']);?></td>
                            <!--<td><?= $subject['menu_name'];
                                ?></td>-->
                            <td><?= h($page['position']);?></td>
                            <td><?= h($page['visible'] == 1? "True":"False");?></td>
                            <td><?= h($page['menu_name']);?></td>
                            <td class = "actions"><a href = <?= url_for("/staff/pages/show.php?id=").h(u($page['id']));?>>View</a></td>
                            <td class = "actions"><a href = <?= url_for("/index.php?page_id=").h(u($page['id'])) . "&preview=true";?>>Preview</a></td>
                            <td class = "actions"><a href = <?= url_for("/staff/pages/edit.php?id=").h(u($page['id']));?>>Edit</a></td>
                            <td class = "actions"><a href = <?= url_for("/staff/pages/delete.php?id=").h(u($page['id']));?>>Delete</a></td>
                        </tr>
                    <?php };?>
                </table>
            </div>
            <?php mysqli_free_result($pages);?>
        </div>
    </div>

</div>
