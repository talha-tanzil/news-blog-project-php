<?php include "header.php";
include 'config.php';
//submit post kora ase kina check kora hocche karon, button er 'name' submit silo, value matter korena ekhane
if (isset($_POST['submit'])) {
    $catName = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $catName = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $sql = "SELECT * category WHERE category_id = {$category_id}";
    $result = mysqli_query($conn, $sql) or die("Category query failed");

    if ($result) {
        header("Location: $hostname/admin/category.php");
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
                $user_id = $_GET['id'];
                $sql = "SELECT * FROM category WHERE category_id = {$category_id}";
                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="cat_id" class="form-control" value="<?= $row['category_id']; ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="cat_name" class="form-control" value="<?= $row['category_name']; ?>" placeholder="" required>
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