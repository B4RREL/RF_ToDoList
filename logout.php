<?php 
    session_start();
    session_destroy(); // destroy the session

    foreach ($_COOKIE as $key => $value) {
        setcookie($key, "", time() - 3600);
    }

    header("Location: ./index.php");
?>