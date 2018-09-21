

<!doctype html>
<html>
<head>
    <meta lang="en">
    <meta charset="utf-8">
    <link media = "all" type ="text/css" rel ="stylesheet" href= <?= url_for("stylesheets/staff.css");?> >
    <title>GBI</title>
</head>

<body>
<header>GBI Staff Area <?= isset($page_title)? '--'.h($page_title):'';?></header>
<nav>
    <ul>
        <li>
            User: <?= $_SESSION['username']??'';?>
        </li>
        <li>
            <a class = 'actions' href=<?= url_for('/staff/index.php');?> > Menu </a>
        </li>
        <li>
            <a class = 'actions' href=<?= url_for('/staff/logout.php');?> > Logout </a>
        </li>
    </ul>
    <?php
    if(isset($_SESSION['status']) && !is_blank($_SESSION['status'])){
         echo "<div id = 'message'>". h( $_SESSION['status'] ) . '</div>';
         unset($_SESSION['status']);
        }?>
</nav>