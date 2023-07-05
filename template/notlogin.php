<?php 
    if(empty($_SESSION['token'])){
        if(empty($_SESSION['token'])){
            header('Location: ./index.php');
        }
    }
?>