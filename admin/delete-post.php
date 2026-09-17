<?php
include "config.php";
if (isset($_GET['id']) && isset($_GET['catid'])){
 $post_id = $_GET['id'];
 $cat_id = $_GET['catid'];
 $sql= "SELECT * FROM post WHERE post_id = {post_id}";
 $result = mysqli_query($conn, $sql) or die("Result query failed: Select");
 $row = mysqli_fetch_assoc($result);
 unlink ("upload/.", $row['post_img']);
 $sql1= "DELETE * FROM post WHERE post_id= $post_id;";
 $sql1 .= "UPDATE category SET post = post-1 WHERE category_id= $cat_id";
 $result1= mysqli_query($conn, $sql1);
 if (mysqli_multi_query($conn,$result1)){
    header("Location: {$hostname}/admin/post.php");
 } else {
    echo '<p style="color:red; margin: 10px 0">Multi-query failed.</p>';
 }
  
} else {
    echo '<p style="color:red; margin: 10px 0">Cant delete the record.</p>';
}
mysqli_close($conn);
?>