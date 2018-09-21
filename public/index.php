<?php require_once('../private/initialize.php'); ?>

<?php
include(SHARED_PATH . '/public_header.php');
$preview = (isset($_GET['preview']) && $_GET['preview'] == true && is_logged_in())? true: false;
$visible = !$preview;
if(isset($_GET['page_id'])) {
        //if preview is not set
        $page = find_page_by_id($_GET['page_id'], ['visible' => $visible]);
        $subject = find_subject_by_id($page['subject_id'], ['visible' => $visible]);
        if (!$page || !$subject) {
            redirect_to(url_for('index.php'));
        }
    }

elseif(isset($_GET['subject_id'])){
    $subject = find_subject_by_id($_GET['subject_id'],['visible' => true]);
    $pages = find_all_pages_by_subject_id($_GET['subject_id'], ['visible' => true]);
    if(!$pages || !$subject) {
        redirect_to(url_for('index.php'));
    }
    else{
        $page = mysqli_fetch_assoc($pages);
        mysqli_free_result($pages);
        if(!$page){
            redirect_to(url_for('index.php'));
        }
    }
}
?>

<div id="main">
    <?php require_once SHARED_PATH . '/public_navigation.php'?>
  <div id="page">

      <?php
      if(isset($page)){
          $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li>';
              echo strip_tags($page['content'],$allowed_tags);
      }
      else{
          include SHARED_PATH . '/static_homepage.php';
      }
        ?>
  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
