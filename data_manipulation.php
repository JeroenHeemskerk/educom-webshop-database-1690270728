<?php 

/**
 * Function connects to "my_webshop" database as user "webshop_user"
 * @return object $conn : Connection to the database
 */
function connectToDatabase() {
    $servername = "localhost";
    $username = "webshop_user";
    $password = "AXN4OSdTm@ua]r4M";
    $dbname = "my_webshop";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        throw new Exception("<br>Failed to connect to MySQL: " . mysqli_connect_error());
    }
    return $conn;
}


/**
 * Function inserts user 'Registration' data into "my_webshop.users" db.table 
 * @param object $conn : Connection to the database
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (user_id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity (TRUE) ]
 */
function storeUser($conn, $data) {
    $email = mysqli_real_escape_string($conn, $data['values']['email']);
    $name = mysqli_real_escape_string($conn, $data['values']['name']);
    $password = mysqli_real_escape_string($conn, $data['values']['password']);

    $sql = "INSERT INTO user (email, name, password)
            VALUES ('$email', '$name', '$password');";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("<br>Failed to store user data: " . mysql_error($conn));
    }
}


/**
 * Function returns user data inside of $data["user"] array
 * User data is queried from "my_webshop.users" db.table
 * @param object $conn : Connection to the database
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : Empty,
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (user_id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function findUserByEmail($conn, $data) {
    $email = mysqli_real_escape_string($conn, $data["values"]["email"]);

    $sql = "SELECT user_id, email, name, password 
            FROM user
            WHERE email = '$email';";

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["email"] == $email) {
                $data["user_already_exists"] = true;
                $data["user"] = $row;
            }
        }
    }
    return $data;
}


/**
 * Function returns user data inside of $data["user"] array
 * User data is queried from "my_webshop.users" db.table
 * @param object $conn : Connection to the database
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : Empty,
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 * @return array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (user_id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function findUserById($conn, $data) {
    $user_id = mysqli_real_escape_string($conn, getLoggedInUserId());

    $sql = "SELECT user_id, email, name, password 
            FROM user
            WHERE user_id = '$user_id';";


    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row["user_id"] == $user_id) {
                $data["user_already_exists"] = true;
                $data["user"] = $row;
            }
        }
    }
    return $data;
}


/**
 * Function updates user password in "my_webshop.users" db.table 
 * @param object $conn : Connection to the database
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (user_id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity (TRUE) ]
 */
function updatePassword($conn, $data) {
    $id = mysqli_real_escape_string($conn, $data['user']['user_id']);
    $new_password = mysqli_real_escape_string($conn, $data['values']['new_password']);


    $sql = "UPDATE user
            SET password = '$new_password'
            WHERE user_id = $id;";

    if (!mysqli_query($conn, $sql)) {
        throw new Exception("<br>Failed to update user data: " . mysql_error($conn));
    }
}


/**
 * Function returns product data inside of $data["products"] array
 * Product data is queried from "my_webshop.product" db.table
 * @param object $conn : Connection to the database
 * @param array $data [    
 *                  "page" => string : Requested page,
 *                  "menu" => array : Menu items,
 *                  "errors" => array : Empty ]
 * @return array $data [    
 *                  "page" => string : Requested page,
 *                  "menu" => array : Menu items,
 *                  "errors" => array : Empty,
 *                  "products" => array [
 *                      "product#..." [
 *                          "product_id" => integer : Product ID,
 *                          "name" => string : Product name,
 *                          "brand" => string : Product brand,
 *                          "description" => string : Product description,
 *                          "price" => float : Product price,
 *                          "filename" => string: Filename of product image in Images folder ]]]
 */
function getProducts($conn, $data) {
    $data["products"] = array();
    $sql = "SELECT product_id, name, brand, description, price, filename 
            FROM product";


    $result = mysqli_query($conn, $sql);
    if (!$result) {
        throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product = "product#" . strval($row["product_id"]);
            $data["products"][$product] = $row;
        }
    }
    return $data;
}


/**
 * Function handles exception when running queries
 * @param string $query_name : Name of query to run
 * @param array $data : Relevant data for user
 * @return array $data : Relevant data for user
 */
function runQuery($query_name, $data) {
    try { 
        $conn = connectToDatabase();
        try {
            switch ($query_name) {
                case "storeUser":
                    storeUser($conn, $data);
                    break;
                case "findUserByEmail":
                    $data = findUserByEmail($conn, $data);
                    break;
                case "findUserById":
                    $data = findUserById($conn, $data);
                    break;
                case "updatePassword":
                    updatePassword($conn, $data);
                    break;
                case "getProducts":
                    $data = getProducts($conn, $data);
                    break;
            }
        }
        finally {
            mysqli_close($conn);
        }
    } 
    catch (Exception $e) {
        $data["errors"]["generic"] = 'Due to technical error, we cannot proceed with this process';
        $data["valid"] = false;
        showLog($e->getMessage());
    }
    return $data;
}