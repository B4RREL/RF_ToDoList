<?php 
session_start(); 
require_once('./template/utilities.php');
$conn = database("localhost","to_do_list","root","");
?>
<?php 
// implemeting logic for login page


    if(isset($_POST['login'])){
         
        $status = true;
        // empty email
        if(!isset($_POST["userEmail"]) || $_POST["userEmail"] == ""){
            $status = false;
            setcookie('emptyEmail', "You have to fill your Email!");
        }

        //empty password
        if(!isset($_POST["userPassword"]) || $_POST["userPassword"] == ""){
            $status = false;
            setcookie('emptyPassword', "You have to fill your Password!");
        }

        if($status){
            $sql = "SELECT password FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":email" => $_POST['userEmail'],
            ]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if($row) { //extra login for if email was wrong
                    if(password_verify($_POST['userPassword'],$row['password'])){

                    // delete old email
                    setcookie("oldEmail", "", time() - 3600);

                    // store session for login
                        $_SESSION['token'] = rand(0000000,9999999) . '_'. $_POST['userEmail'].rand(0000000,9999999);

                    // store cookie for login
                        setcookie('token', $_SESSION['token'], time() + (3600*24));

                        $sql = "SELECT * FROM users WHERE email = :email";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            ':email' => $_POST['userEmail'],
                        ]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['userID'] = rand(0000000,9999999). $user['id']. rand(0000000000,9999999999);

                        header('Location: ./dashboard.php');
                    } else {
                        setcookie("wrongPassword", "Wrong Password");
                        setcookie("oldEmail", $_POST['userEmail']); // old email
                        header("Location: ./index.php");
                    }
                } else {
                    setcookie('invalidEmail', "This email has not registered yet");
                    setcookie("oldEmail", $_POST['userEmail']);
                    header("Location: ./index.php");
                }
        } else {
            setcookie("oldEmail", $_POST['userEmail']);
            header("Location: ./index.php");
        }
    }
 ?>