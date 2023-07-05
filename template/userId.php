<?php 
    session_start();
    if(isset($_SESSION['userID'])){
        $length = strlen($_SESSION['userID']) - 17;
        $userId = substr($_SESSION['userID'],7,$length);
        echo $userId;
    }
?> 