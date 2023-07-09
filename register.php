<?php
session_start(); 
require_once("./template/header.php");
require_once("./template/db.php");
require_once("./template/logined.php");
 ?>



<?php 
    if(isset($_POST["register"])){

        $status = true;
        // userName validation
        if(!isset($_POST["userName"]) || $_POST["userName"] == ""){
            $status = false;
            setcookie('emptyName', "You have to fill your username!");
        }
        //email validation
        if(!isset($_POST["userEmail"]) || $_POST["userEmail"] == ""){
            $status = false;
            setcookie('emptyEmail', "You have to fill your Email!");
        }else {
           $sql = "SELECT * FROM users WHERE email = :email";
           $stmt = $conn->prepare($sql);
           $stmt->execute([
            ":email" => $_POST['userEmail'],
           ]);
           $row = $stmt->fetch(\PDO::FETCH_ASSOC);

           if($row){
             $status = false;
             setcookie('sameEmail', "Email has already been taken");
           }
        }
        //password validation
        if(!isset($_POST["userPassword"]) || $_POST["userPassword"] == ""){
            $status = false;
            setcookie('emptyPassword', "You have to fill your Password!");
        }else {
            $strongPassword = true;

            if(!preg_match("/[a-z]/",$_POST["userPassword"])){
                $strongPassword = false;
            }elseif(!preg_match("/[A-Z]/",$_POST["userPassword"])){
                $strongPassword = false;
            }elseif(!preg_match("/[0-9]/",$_POST["userPassword"])){
                $strongPassword = false;
            }elseif(!preg_match("/[!@#$%^&*~()]/",$_POST["userPassword"])){
                $strongPassword = false;
            }

            if($strongPassword == false){
                setcookie('weakPassword', "Your password must contain capital letters, small letters, numbers and special charaters!");
            }
        }

        

        // password and confirm password not match
        if($_POST["userPassword"] != $_POST["confirmPassword"]){
            $status = false;
            setcookie('notMatchPassword', "Your password does not match the one you already submitted");
        }

       

        if($status && $strongPassword){
            //delete old email and name
            setcookie("oldRegisterName", "", time() - 3600);
            setcookie("oldRegisterEmail", "", time() - 3600);

            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"; 
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":name" => $_POST['userName'],
                ":email" => $_POST['userEmail'],
                ":password" => password_hash($_POST['userPassword'],PASSWORD_DEFAULT),
            ]);

            // store session for login
                $_SESSION['token'] = rand(0000000,9999999) . '_'. $_POST['userName'].rand(0000000,9999999);

            // store cookie for login
                setcookie('token', $_SESSION['token'], time() + (3600*24));

            //get user form data base
            $sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":email" => $_POST['userEmail'],
            ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // store user id
            // to protect from view source
            $_SESSION['userID'] = rand(0000000,9999999).$user['id'].rand(0000000000,9999999999);

            header('Location: ./dashboard.php');
        }else{
            setcookie("oldRegisterName", $_POST['userName']);
            setcookie("oldRegisterEmail", $_POST['userEmail']);
            header("Location: ./register.php");
        }
    }
?>
    
<section>
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
            <div class="container-sm-fluid container-md">
                <a class="navbar-brand text-primary" href="#">CRUD Project with pure PHP</a>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-primary" href="./index.php">Login</a>
                    </li>
                </ul>
            </div>
        </nav>
</section>


<section class="vh-100 row align-items-center g-0">
        <div class="col-8 col-md-6 col-lg-5 mx-auto">
            <div class="card text-primary">
                <div class="card-header text-center h3">
                    Register Form
                </div>
                <div class="card-body">
                    <form action="./register.php" method="POST">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="name" name="userName" id="name" class="form-control" value="<?php 
                            if(isset($_COOKIE['oldRegisterName'])){
                                echo htmlentities($_COOKIE['oldRegisterName']);
                            }
                            ?>" placeholder="Enter your Name...">
                            <p class="text-danger">
                                <?php  //flash message
                                    if(isset($_COOKIE['emptyName'])){
                                        echo $_COOKIE['emptyName'];
                                        setcookie('emptyName', '', time() - 3600);
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="userEmail"  id="email" class="form-control" value="<?php
                            if(isset($_COOKIE['oldRegisterEmail'])){
                                echo htmlentities($_COOKIE['oldRegisterEmail']);
                            }
                            ?>" placeholder="Enter your Email...">
                            <p class="text-danger">
                                <?php 
                                    if(isset($_COOKIE['emptyEmail'])){
                                        echo $_COOKIE['emptyEmail'];
                                        setcookie('emptyEmail', '', time() - 3600);
                                    }
                                    if(isset($_COOKIE['sameEmail'])){
                                        echo $_COOKIE['sameEmail'];
                                        setcookie('sameEmail', '', time() - 3600);
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="userPassword" id="password" value="" class="form-control" placeholder="Enter your Password...">
                            <p class="text-danger">
                                <?php 
                                    if(isset($_COOKIE['emptyPassword'])){
                                        echo $_COOKIE['emptyPassword'];
                                        setcookie('emptyPassword', '', time() - 3600);
                                    }elseif(isset($_COOKIE['weakPassword'])){
                                        echo $_COOKIE['weakPassword'];
                                        setcookie('weakPassword', '', time() - 3600);
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" value="" class="form-control" placeholder="Confirm Password...">
                            <p class="text-danger">
                                <?php 
                                    if(isset($_COOKIE['notMatchPassword'])){
                                        echo $_COOKIE['notMatchPassword'];
                                        setcookie('notMatchPassword', '', time() - 3600);
                                    }
                                ?>
                            </p>
                        </div>
                        <input type="submit" name="register" class="btn btn-primary mt-3 w-100" value="Register" />
                           
                        
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php require_once("./template/footer.php") ?>