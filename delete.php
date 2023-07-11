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

    $currentUserId = getUserID();

    
    // to prevent to deleting other users data 
   if($row['user_id'] != $currentUserId){
        block($row['user_id'],$currentUserId);
   } else {
        $sql = "DELETE FROM to_do_list WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":id" => $_GET['id'],
        ]);

        setcookie("success", "You deleted a list");
        header("Location: ./dashboard.php");
   }
?>


