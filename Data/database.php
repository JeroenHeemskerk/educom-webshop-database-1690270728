<?php 

$servername = "localhost";
$username = "webshop_user";
$password = "AXN4OSdTm@ua]r4M";
$dbname = "my_webshop";

function connectToDB() {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

