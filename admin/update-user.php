<?php

include 'header.php';
include 'config.php';
//submit post kora ase kina check kora hocche karon, button er name submit silo

if (isset($_POST['submit'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lname = mysqli_real_escape_string($conn, $_POST['l_name']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    // $password = mysqli_real_escape_string($conn, md5($_POST['password']));// password option ta deactivate kora hoise, karon password aikhaner update form e nai
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    // sql query and connection
    $sql = "UPDATE user SET first_name ='$fname', last_name = '$lname',username = '$user', role ='$role' WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql) or die("Query failed");

    if ($result) {
        header("Location: $hostname/admin/users.php");
    }
}

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <!-- Form Start -->
                <?php

                $user_id = $_GET["id"];

                $sql = "SELECT * FROM user WHERE user_id= {$user_id}";

                $result = mysqli_query($conn, $sql) or die("Query failed");

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?= $row['user_id'] ?>"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?= $row['first_name'] ?>"
                                    placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?= $row['last_name'] ?>"
                                    placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?= $row['username'] ?>"
                                    placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                                    <?php if ($row['role'] == 1) {
                                        echo "<option value='0'>normal User</option>
                                    <option value='1' selected>Admin</option>";
                                    } else {
                                        echo "<option value='0' selected>normal User</option>
                                    <option value='1'>Admin</option>";
                                    }
                                    ; ?>
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <?php
                    }
                }
                ?>
                <!-- /Form -->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>