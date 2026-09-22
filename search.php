<?php include 'header.php';
include 'db.php';
?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">

                    <?php
                    if (isset($_GET['search'])) {

                        $search_term = mysqli_escape_string($conn,$_GET['search']);// $search_term = $_GET['search'];

                        ?>
                        <h2 class="page-heading">Search : <?php echo $search_term; ?>
                        </h2>
                        <?php
                        /* Calculate Offset Code */
                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $offset = ($page - 1) * $limit;
                        $sql = "SELECT post.post_id, post.title, post.description,post.category, post.post_date, post.author, post.post_img,
                    category.category_name,user.username FROM post
                    LEFT JOIN category ON post.category = category.category_id
                    LEFT JOIN user ON post.author = user.user_id
                    WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%' OR user.username LIKE '%{$search_term}%' OR post.post_date LIKE '%{$search_term}%' OR category.category_name LIKE '%{$search_term}%'  
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";

                        $result = mysqli_query($conn, $sql) or die("search 1st query failed");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class="post-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="post-img" href="single.php?id=<?php echo $row['post_id']; ?>"><img
                                                    src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="inner-content clearfix">
                                                <h3><a
                                                        href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a>
                                                </h3>
                                                <div class="post-information">
                                                    <span>
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <a
                                                            href='category.php?search=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <a
                                                            href='author.php?search=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo $row['post_date']; ?>
                                                    </span>
                                                </div>
                                                <p class="description">
                                                    <?php echo substr($row['description'], 0, 130) . "..."; ?>
                                                </p>
                                                <a class='read-more pull-right'
                                                    href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<h2>No post or result found.</h2>";
                        }

                        // show pagination
                        //aikhane alada unnecessary sql2 query, $result2 and $row2 lekha hoini category.php er moto, karon sobkisu $sql1 ei ase. sudhu (mysqli_num_rows($result2)>0){} ai part theke shuru korlei hobe.
                         

                        $sql1 = "SELECT * FROM post WHERE post.title = '%{$search_term}%'";// ai case e curly brace dileo hobe, na dileo hobe. $search_term12 emon hole variable ta alada vabe bujte curly brace deya lagto, like: {$search_term}12 hobe.

                        // arekta bisoi '%{$search_term}%' er 2pashe curly brace optional, kintu % and single quotation mandatory.
                        $result1 = mysqli_query($conn, $sql1) or die("search 2nd query failed");
                        $row1 = mysqli_fetch_assoc($result1);
                        if (mysqli_num_rows($result1) > 0) {
                            $total_records = mysqli_num_rows($result1);
                            //aikhane category.php er moto $total_records = $row2['post']; hobena, karon etar query te post name er kono column exist korena.
                            $total_page = ceil($total_records / $limit);
                            echo "<ul class='pagination admin-pagination'>";
                            if ($page > 1) {
                                echo '<li><a href="author.php?search=' . $search_term . '&page=' . ($page - 1) . '">Prev</a></li>'; //baire 1st quotation thakai concatenation use kora hoise, 2nd quotation thakle 2nd bracket use kora hoito variable er upor 
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                if ($i == $page) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                                echo '<li class="' . $active . '"><a href="author.php?search=' . $search_term . '&page=' . $i . '">' . $i . '</a></li>';

                                /*echo er baire double quotation likle evabe liklei hoi which is more easier:
                                 echo "<li class='$active'><a href='category.php?cid=$cat_id&page=$i'>$i</a></li>";*/
                            }
                            if ($total_page > $page) {
                                echo '<li><a href="author.php?search=' . $search_term . '&page=' . ($page + 1) . '">Next</a></li>';
                            }
                            echo "</ul>";
                            // pagination process ends here
                        }
                    } else {
                        echo "<h2> No record found. </h2>";
                    }

                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>