<?php include "header.php";
include 'config.php';
if($_SESSION["user_role"] == '0'){
  header("Location: {$hostname}/admin/post.php");
}
//submit post kora ase kina check kora hocche karon, button er 'name' submit silo, value matter korena ekhane
if (isset($_POST['submit'])) {
    $catId = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $catName = mysqli_real_escape_string($conn, $_POST['cat_name']);

    /* query for checking input value exists in category table or not*/
    $sql = "SELECT category_name from category WHERE category_name= '$catName' AND NOT category_id = '{$catId}'";
    $result = mysqli_query($conn, $sql) or die("Category query failed");

    //if input value exists:
    if (mysqli_num_rows($result) > 0) {
        echo "<p style= 'color:red; text-align:center; margin: 0 auto';>Category name '.$catName.' already exists. </p>";
    } else {
        // if input value not exists
        /* query for update category table */
        $sql1 = "UPDATE category SET category_name= '{$_POST['cat_name']}' WHERE category_id= {$_POST['cat_id']}";
        $result1 = mysqli_query($conn, $sql1) or die("Update category query failed");
        if ($result1) {
            header("Location: $hostname/admin/category.php");
        }
    }
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="adin-heading"> Update Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <?php
                $cat_id = $_GET['id'];
                $sql2 = "SELECT * FROM category WHERE category_id = {$cat_id}";
                $result2 = mysqli_query($conn, $sql2) or die("Query Failed.");
                if (mysqli_num_rows($result2) > 0) {
                    while ($row = mysqli_fetch_assoc($result2)) {
                        ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="cat_id" class="form-control" value="<?= $row['category_id']; ?>"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="cat_name" class="form-control" value="<?= $row['category_name']; ?>"
                                    placeholder="" required>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>