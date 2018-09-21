 <?php
require_once "../../../private/initialize.php";
 required_login();

redirect_to(url_for('/staff/index.php'));

include SHARED_PATH.'/staff_footer.php';?>