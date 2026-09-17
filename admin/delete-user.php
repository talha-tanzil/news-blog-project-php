<?php
include 'config.php';
if($_SESSION["user_role"] == '0'){
  header("Location: {$hostname}/admin/post.php");
}
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE user_id= $id";
    $result = mysqli_query($conn, $sql);
    header ("Location: {$hostname}/admin/users.php");
} 

  else {
    echo "<p style='color:red; margin: 10px 0;'>Can't delete the record</p>";
}

mysqli_close($conn);