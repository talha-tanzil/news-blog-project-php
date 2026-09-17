<?php include "header.php";
include '../db.php';
if ($_SESSION["user_role"] == '0') {
    header("Location: {$hostname}/admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Users</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-user.php">add user</a>
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

                $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}"; // aikhane curly brace er 
                $result = mysqli_query($conn, $sql) or die("Query failed");
                //aikhane mysqli_num_rows function use korle data/ row na paile table e show korbe na
                if (mysqli_num_rows($result) > 0) { ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Full Name</th>
                            <th>User Name</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            /*  if (mysqli_num_rows($result) > 0) { ?> */ //aikhane mysqli_num_rows use korle data na thakleo table dekhabe, kintu row dekhabe na
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td class='id'><?php echo $serial; ?></td>
                                    <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td>
                                        <?php
                                        if ($row["role"] == 1) {
                                            echo "Admin";
                                        } else {
                                            echo "Normal User";
                                        }
                                        ; ?>
                                    </td>
                                    <td class='edit'><a href='update-user.php?id=<?= $row["user_id"] ?>'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?= $row["user_id"] ?>'><i
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
                    echo "Data not found";

                }
                $sql1 = "SELECT * FROM user";
                $result1 = mysqli_query($conn, $sql1) or die("Query1 failed");
                $total_records = mysqli_num_rows($result1);
                if ($total_records > 0) {

                    // $limit = 3;// uporei ekbare $limit dhora hoise, tai aikhane eta deactivate/commment kora hoise.
                    $total_pages = ceil($total_records / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    if ($page > 1) {
                        echo '<li><a href="users.php?page=' . ($page - 1) . '">Prev</a></li>';  //aita 'prev' button ke dynamic korar code 
                    }
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        echo "<li class= '" . $active . "'><a href='users.php?page=" . $i . "'>" . $i . "</a></li>";// aitai for loop er main kaj aikhane
                    }
                    if ($total_pages > $page) {
                        echo '<li><a href="users.php?page=' . ($page + 1) . '">Next</a></li>';// aita 'next' button ke dinamic korar code 
                    }
                    echo "</ul>";
                }
                ?>

                <!-- <li class="active"><a>1</a></li> -->
                <!-- </ul> -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>