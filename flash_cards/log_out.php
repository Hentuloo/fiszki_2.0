<?php
session_start();
if(isset($_SESSION['active_user'])){
    unset($_SESSION['active_user']);
    header('location: index.php');
}
else{
    header('location: index.php');
}
?>
