<?php
include 'connection.php';
session_start();
$id = $_GET['id'];
$query = mysqli_query($connect, "DELETE FROM item WHERE item_id=$id");

if ($query) {
    header("Location:admin_main.php?message=success");
} else {
    header("Location:admin_main.php?message=failed");
}


?>