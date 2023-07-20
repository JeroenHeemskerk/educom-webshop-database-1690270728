<?php 

/**
 * Function that connects to "my_webshop" database as user "webshop_user"
 * @return object $conn : Connection to the database
 */
function connectToDB() {
    $servername = "localhost";
    $username = "webshop_user";
    $password = "AXN4OSdTm@ua]r4M";
    $dbname = "my_webshop";

    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("<br>Connection failed: " . $conn->connect_error);
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    return $conn;
}


/**
 * Function that inserts user 'Registration' data into "my_webshop.users" db.table 
 * @param string $email : User email
 * @param string $name : User name
 * @param string $password : User password
 */
function storeUser($email, $name, $password) {
    $conn = connectToDB();

    try {
        $sql = "INSERT INTO users (email, name, password)
                VALUES ('". $email ."', '". $name."', '".$password."');";
        if ($conn->error) {
            throw new Exception("<br>Insert Error: " . $conn->error);
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        $conn->close();
    }
}


/**
 * Function that queries user data from "my_webshop.users" db.table, and stores the query result inside the $data["user"] array
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : (Empty),
 *                  "user" => array : (Empty),
 *                  "valid" => boolean: Data validity ]
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : (Empty),
 *                  "user" => array : User data from database (email, name, password),
 *                  "valid" => boolean: Data validity ]
 */
function findUserByEmail($data) {
    $conn = connectToDB();

    $sql = "SELECT email, name, password 
            FROM users 
            WHERE email = '" . $data['values']['email'] . "';";
    try {
        $result = $conn->query($sql);
        if ($conn->error) {
            throw new Exception("<br>Select Error: " . $conn->error);
        }
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $data["user"]["user_exists"] = true;
            $data["user"]["email"] = $user["email"];
            $data["user"]["name"] = $user["name"];
            $data["user"]["password"] = $user["password"];
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        $conn->close();
    }
    return $data;
}