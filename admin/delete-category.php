<?php
include 'config.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "DELETE FROM category WHERE category_id= $id";
    $result = mysqli_query($conn, $sql);
    header ("Location: {$hostname}/admin/category.php");
} 

  else {
    echo "<p style='color:red; margin: 10px 0;'>Can't delete the record</p>";
}

mysqli_close($conn);