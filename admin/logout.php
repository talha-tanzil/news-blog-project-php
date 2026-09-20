<?php
include ('config.php');

//logout/session part
session_start();
session_unset(); //it means: whatever variables we've created inside the session will be removed
session_destroy();
header("Location: $hostname/admin");
?>
