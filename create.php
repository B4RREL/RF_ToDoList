<?php
    session_start();
    require_once "./template/header.php";
    require_once "./template/utilities.php";
    $conn = database("localhost","to_do_list","root","");
    notLogined();
?>
<?php 
    if(isset($_POST['createBtn'])){
        $status = true;

        //empty title
        if(!isset($_POST['title']) || $_POST['title'] == ""){
            setcookie('emptyTitle', "You have to fill the list title");
            $status = false;
        }

        //empty deadline
        if(!isset($_POST['deadline']) || $_POST['deadline'] == ""){
            setcookie('emptyDeadline', "You have to fill the list Deadline");
            $status = false;
        }

        if($status){
            
            $userId = getUserID();

            $sql = "INSERT INTO to_do_list (user_id, title, deadline) VALUES (:user_id, :title, :deadline)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":user_id" => $userId,
                ":title" => $_POST['title'],
                ":deadline" => $_POST['deadline'],
            ]);
            setcookie('success',"You have successfully created a new list");

            header("Location: ./dashboard.php");
        } else {
            header("Location: ./create.php");
        }
    }
?>
    <section>
        <nav class="navbar navbar-expand-lg bg-transparent fixed-top">
            <div class="container-sm-fluid container-md">
                <a class="navbar-brand text-primary font-script" href="#">CRUD Project with pure PHP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active text-primary" aria-current="page" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="./create.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="./logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <section id="createList" class="vh-100 row align-items-center g-0">
        <div class="col-8 col-md-6 col-lg-5 mx-auto">
            <div class="card text-primary">
                <div class="card-header text-center h3">
                    Create List
                </div>
                
                <div class="card-body">
                    <form action="./create.php" method="POST">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="Enter your list...">
                            <p class="text-danger">
                                <?php 
                                flashMessage('emptyTitle');
                                ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input name="deadline" type="date" class="form-control" id="deadline" placeholder="Enter list deadline...">
                            <p class="text-danger">
                                <?php 
                                flashMessage('emptyDeadline');
                                ?>
                            </p>
                        </div>
                        <input name="createBtn" type="submit" class="btn btn-primary mt-3 w-100" value="Create" />
                        
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once "./template/footer.php"
?>