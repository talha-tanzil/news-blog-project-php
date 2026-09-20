<?php include "header.php";
include 'config.php';
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <?php
                $limit = 3;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $limit;

                $sql = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset}, {$limit}"; // aikhane curly brace er 
                $result = mysqli_query($conn, $sql) or die("Query failed");
                // aikhane mysqli_num_rows function use korle data/ row na paile table e show korbe na
                if (mysqli_num_rows($result) > 0) { ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Category Name</th>
                            <th>No. of Posts</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                /*  if (mysqli_num_rows($result) > 0) { ?> */ //aikhane mysqli_num_rows use korle data na thakleo table dekhabe, kintu row dekhabe na
                                $serial = $offset + 1;
                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <td class='id'><?php echo $serial; ?></td>
                                    <td><?= $row['category_name']; ?></td>
                                    <td><?= $row['post']; ?></td>
                                    <td class='edit'><a href='update-category.php?id=<?= $row["category_id"] ?>'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-category.php?id=<?= $row["category_id"] ?>'><i
                                                class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php
                                $serial++;
                                }
                                ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo "Data not found.";
                }
                // pagination query
                $sql1 = "SELECT COUNT(category_id) FROM category";
                $result1 = mysqli_query($conn, $sql1) or die("Query1 failed");
                $row_db = mysqli_fetch_assoc($result1);
                $total_records = $row_db['COUNT(category_id)'];
                $total_pages = ceil($total_records / $limit);

                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo '<li><a href="category.php?page=' . ($page - 1) . '">Prev</a></li>';  //aita 'prev' button ke dinamic korar code 
                }
                if ($total_records > $limit) {
                    for ($i = 1; $i <= $total_pages; $i++) {

                        if ($i == $page) {
                            $cls = 'btn-primary active';
                        } else {
                            $cls = 'btn-primary';
                        }
                        echo "<li class= '" . $cls . "'><a href='category.php?page=" . $i . "'>" . $i . "</a></li>";// aitai for loop er main kaj aikhane
                    }
                }
                if ($total_pages > $page) {
                    echo '<li><a href="category.php?page=' . ($page + 1) . '">Next</a></li>';// aita 'next' button ke dinamic korar code 
                }
                echo "</ul>";
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>