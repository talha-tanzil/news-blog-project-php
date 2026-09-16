<?php
$hostname = "http://localhost/news-blog-project-php/news-site" ;
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'news-site';

// Create connection
$conn =new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//  echo "Connected successfully 1";

?>