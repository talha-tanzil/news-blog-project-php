<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] == '0') { ?>
        <h1>File not found.</h1>
        <?php
    } ?>
</body>

</html>