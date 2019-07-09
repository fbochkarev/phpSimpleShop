<?php
include 'elems/init.php';

if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin' && !empty($_POST['id']) && !empty($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if ($status == 'admin'){
        $query = "UPDATE users SET status_id='1' WHERE id='$id'";
        mysqli_query($link, $query) or die($link);
    } elseif ($status == 'user') {
        $query = "UPDATE users SET status_id='2' WHERE id='$id'";
        mysqli_query($link, $query) or die($link);
    }

    header('Location: /shop/admin.php');
}