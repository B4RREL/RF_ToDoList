<?php 
require_once "./template/header.php";
require_once "./template/utilities.php";
$conn = database("localhost","to_do_list","root","");
notLogined();

$userId = getUserID();
?>
<?php 
 $sql = "SELECT * FROM to_do_list WHERE user_id = :user_id";
 $stmt = $conn->prepare($sql);
 $stmt->execute([
    ':user_id' => $userId,
 ]);
 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

 echo json_encode($rows);
?>