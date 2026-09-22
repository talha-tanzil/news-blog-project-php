<?php
 include 'header.php';
 include 'db.php';
?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    if (isset($_GET['aid'])) {
                         
                         $auth_id = $_GET['aid'];

                        $sql1 = "SELECT * FROM post JOIN user ON post.author= user.user_id WHERE post.author = {$auth_id}";// ai case e curly brace dileo hobe, na dileo hobe. $auth_id12 emon hole variable ta alada vabe bujte curly brace deya lagto, like: {$auth_id}12 hobe.
                         $result1 = mysqli_query($conn, $sql1) or die("Author 1st query failed");
                    $row1 = mysqli_fetch_assoc($result1);
                    
                    ?>
                  <h2 class="page-heading">Author Name: <?php echo $row1['first_name']. " ".$row1['last_name']; ?></h2>
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
                    WHERE post.author = {$auth_id}
                    ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";

                        $result = mysqli_query($conn, $sql) or die("Author 2nd query failed");
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
                                                            href='category.php?aid=<?php echo $row['category']; ?>'><?php echo $row['category_name']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
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
                        
                        if (mysqli_num_rows($result1) > 0) {
                            $total_records = mysqli_num_rows($result1);
                            //aikhane category.php er moto $total_records = $row2['post']; hobena, karon etar query te post name er kono column exist korena.
                            $total_page = ceil($total_records / $limit);
                            echo "<ul class='pagination admin-pagination'>";
                            if ($page > 1) {
                                echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page - 1) . '">Prev</a></li>'; //baire 1st quotation thakai concatenation use kora hoise, 2nd quotation thakle 2nd bracket use kora hoito variable er upor 
                            }
                            for ($i = 1; $i <= $total_page; $i++) {
                                if ($i == $page) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                                echo '<li class="'.$active.'"><a href="author.php?aid='.$auth_id.'&page='.$i.'">'.$i.'</a></li>';

                                /*echo er baire double quotation likle evabe liklei hoi which is more easier:
                                 echo "<li class='$active'><a href='category.php?cid=$cat_id&page=$i'>$i</a></li>";*/
                            }
                            if ($total_page > $page) {
                                echo '<li><a href="author.php?aid=' . $auth_id . '&page=' . ($page + 1) . '">Next</a></li>';
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