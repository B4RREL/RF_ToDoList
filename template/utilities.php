<?php 

//connect database
function database($localhost, $dbname, $user, $pass) {
    try {
    $conn = new PDO("mysql:host=$localhost;dbname=$dbname",$user,$pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
}
    
// logined 
function logined() {
    if(isset($_SESSION['token']) || isset($_COOKIE['token'])){
            header("Location: ./dashboard.php");
        }
}
    
// not login
function notLogined(){
    if(empty($_SESSION['token'])){
        if(empty($_SESSION['token'])){
            header('Location: ./index.php');
        }
    }
}

//get UserId   
function getUserID() {
        if(isset($_SESSION['userID'])){
        $length = strlen($_SESSION['userID']) - 17;
        $userId = substr($_SESSION['userID'],7,$length);
        return $userId;
    }
}

function flashMessage($message){
    if(isset($_COOKIE[$message])){
        echo $_COOKIE[$message];
        setcookie($message, '', time() - 3600);
    }
}

function oldData($data){
    if(isset($_COOKIE[$data])){
        echo htmlentities($_COOKIE[$data]);
    }
}
?> 