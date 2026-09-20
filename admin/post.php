<?php
include "header.php";
include 'config.php';// database configuration
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Posts</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-post.php">add post</a>
            </div>
            <div class="col-md-12">
                <?php
                /* Calculate Offset Code */
                $limit = 3;
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $limit;
                /* select query of post table with offset and limit */
                if ($_SESSION["user_role"] == '1') {
                    /* select query of post table for admin user */
                    $sql = "SELECT post.post_id, post.title, post.description,post.category, post.post_date,
                    category.category_name,user.username FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                } elseif ($_SESSION["user_role"] == '0') {
                    /* select query of post table for normal user */
                    $sql = "SELECT post.post_id, post.title, post.description,post.category, post.post_date,
                    category.category_name,user.username FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE post.author = {$_SESSION['user_id']}
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";
                }
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {

                    ?>
                    <table class="content-table">
                        <thead>
                            <th>S.No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Author</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $serial = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td class='id'><?php echo $serial ?></td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['category'] ?></td>
                                    <td><?= $row['post_date'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td class='edit'><a href='update-post.php?id=<?= $row['post_id'] ?>'><i
                                                class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?= $row['post_id'] ?>&catid=<?= $row['category']; ?>'><i
                                                class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php
                                $serial++;
                                ?>
                            </tbody>
                            <?php
                            }
                            ?>
                    </table>
                    <?php
                } else {
                    echo "No post table results found.";
                }

                // showing pagination below in this process explained below:
                if($_SESSION["user_role"] == '1'){
                  /* select query of post table for admin user */
                  $sql1 = "SELECT * FROM post";
                }elseif($_SESSION["user_role"] == '0'){
                  /* select query of post table for normal user */
                  $sql1 = "SELECT * FROM post
                  WHERE author = {$_SESSION['user_id']}";
                }

                $result1 = mysqli_query($conn, $sql1);
                $total_records = mysqli_num_rows($result1);
                $total_page = ceil($total_records / $limit);
                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo '<li><a href="post.php?page=' . ($page - 1) . '">Prev</a></li>';
                }
                for ($i = 1; $i < $total_page; $i++) {
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo "<li class='.$active.'><a href='post.php?page='.$i.''>'.$i.'</a></li>";
                    if ($total_page > $page) {
                        echo '<li><a href="post.php?page=' . ($page + 1) . '">Next</a></li>';
                    }
                    echo "</ul>";
                    // pagination process ends here
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>