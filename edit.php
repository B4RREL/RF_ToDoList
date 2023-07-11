<?php
    require_once "./template/header.php";
    require_once "./template/utilities.php";
    $conn = database("localhost","to_do_list","root","");
    notLogined();
?>
<?php 
    // old data
    $sql = "SELECT * FROM to_do_list WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":id" => $_GET['id'],
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php 
    if(isset($_POST['editBtn'])){
        $status = true;

         //empty title
         if(!isset($_POST['title']) || $_POST['title'] == ""){
            setcookie('emptyEditTitle', "You have to fill the list title");
            $status = false;
        }

        //empty deadline
        if(!isset($_POST['deadline']) || $_POST['deadline'] == ""){
            setcookie('emptyEditDeadline', "You have to fill the list Deadline");
            $status = false;
        }

        if($status){
             //delete old data
            setcookie("oldData", "",time() - 3600);
            
            $sql = "UPDATE to_do_list SET title = :title, deadline = :deadline WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":title" => $_POST['title'],
                ":deadline" => $_POST['deadline'],
                ":id" => $_POST['id'],
            ]);

            setcookie("success","You have edited a list");
            header("Location: ./dashboard.php");
        } else {
            setcookie("oldData",$_POST['title']);
            header("Location: ./edit.php?id=" . $_POST['id']);
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
                    Edit List
                </div>
                
                <div class="card-body">
                    <form action="./edit.php" method="POST">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= htmlentities($row['id']) ?>">
                            <label for="title" class="form-label">Title</label>
                            <input name="title" type="text" value="<?php
                                if(isset($_COOKIE['oldData'])){
                                    echo htmlentities($_COOKIE['oldData']);
                                } elseif (isset($row['title'])){
                                    echo htmlentities($row['title']);
                                }
                            ?>" class="form-control" id="title" placeholder="Enter your list...">
                            <p class="text-danger">
                                <?php 
                                flashMessage('emptyEditTitle');
                                ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input name="deadline" type="date" class="form-control" id="deadline" placeholder="Enter list deadline...">
                            <p class="text-danger">
                                <?php 
                                flashMessage('emptyEditDeadline');
                                ?>
                            </p>
                        </div>
                        <input name="editBtn" type="submit" class="btn btn-primary mt-3 w-100" value="Edit" />
                        
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once "./template/footer.php"
?>