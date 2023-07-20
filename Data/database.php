<?php 

function connectDB() {
    define("SERVERNAME", "localhost");
    define("USERNAME", "webshop_user");
    define("PASSWORD", "AXN4OSdTm@ua]r4M");
    define("DBNAME", "my_webshop");
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

define("SERVERNAME", "localhost");
define("USERNAME", "webshop_user");
define("PASSWORD", "AXN4OSdTm@ua]r4M");
define("DBNAME", "my_webshop");
try {
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
}
catch(Exception $e) {
    echo $e->getmessage();
}
echo "Connected succesfully to DB";
