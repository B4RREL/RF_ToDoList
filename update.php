<?php 
    session_start();
    require_once "./template/header.php";
    require_once "./template/utilities.php";
    $conn = database("localhost","to_do_list","root","");
    notLogined();
?>
<?php 
    $sql = "UPDATE to_do_list SET done = :done WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':done' => $_POST['check'],
        ':id' => $_POST['id'],
    ])
?>