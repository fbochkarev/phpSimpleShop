<?php
include 'elems/init.php';

if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin' && !empty($_POST['id'])) {
    $id = $_POST['id'];
    $banned = $_POST['banned'];

    if ($banned == 1){
        $query = "UPDATE users SET banned=0 WHERE id='$id'";
        mysqli_query($link, $query) or die($link);
        header('Location: /shop/admin.php');
    }

    if ($banned == 0) {
        $query = "UPDATE users SET banned=1 WHERE id='$id'";
        mysqli_query($link, $query) or die($link);
        header('Location: /shop/admin.php');
    }
}