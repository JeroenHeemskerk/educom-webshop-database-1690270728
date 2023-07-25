<?php 

/**
 * Function connects to "my_webshop" database as user "webshop_user"
 * @return object $conn : Connection to the database
 */
function connectToDB() {
    $servername = "localhost";
    $username = "webshop_user";
    $password = "AXN4OSdTm@ua]r4M";
    $dbname = "my_webshop";

    try {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            throw new Exception("<br>Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    return $conn;
}


/**
 * Function inserts user 'Registration' data into "my_webshop.users" db.table 
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity (TRUE) ]
 */
function storeUser($data) {
    $conn = connectToDB();
    $email = mysqli_real_escape_string($conn, $data['values']['email']);
    $name = mysqli_real_escape_string($conn, $data['values']['name']);
    $password = mysqli_real_escape_string($conn, $data['values']['password']);

    try {
        $sql = "INSERT INTO user (email, name, password)
                VALUES ('$email', '$name', '$password');";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to insert user data: " . mysql_error($conn));
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        mysqli_close($conn);
    }
}


/**
 * Function queries user data from "my_webshop.users" db.table, and stores the query result inside the $data["user"] array
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
 *                  "user" => array : User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity ]
 */
function findUserByEmail($data) {
    $conn = connectToDB();
    $email = mysqli_real_escape_string($conn, $data["values"]["email"]);

    $sql = "SELECT user_id, email, name, password 
            FROM user
            WHERE email = '$email';";
    try {
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
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        mysqli_close($conn);
    }
    return $data;
}


/**
 * Function uses "Change Password" data to update user password in "my_webshop.users" db.table 
 * @param array $data [
 *                  "page" => string : Requested page,
 *                  "values" => array : User data submitted (clean),
 *                  "errors" => array : Empty,
 *                  "user" => array : User data from database (id, email, name, password),
 *                  "user_already_exists" => boolean : Flag variable,
 *                  "valid" => boolean: Data validity (TRUE) ]
 */
function updatePassword($data) {
    $conn = connectToDB();
    $id = mysqli_real_escape_string($conn, $data['user']['id']);
    $new_password = mysqli_real_escape_string($conn, $data['values']['new_password']);

    try {
        $sql = "UPDATE user
                SET password = '$new_password'
                WHERE user_id = $id;";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to update user data: " . mysql_error($conn));
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        mysqli_close($conn);
    }
}


/**
 * Function queries product data from "my_webshop.product" db.table, and returns the query result inside the $products array
 * @return array $products => array $product_#... [
 *                                      "product_id" => integer : Product ID,
 *                                      "name" => string : Product name,
 *                                      "brand" => string : Product brand,
 *                                      "description" => string : Product description,
 *                                      "price" => float : Product price,
 *                                      "filename" => string: Filename of product image in Images folder ]
 */
function getProducts() {
    $products = array();
    $conn = connectToDB();
    $sql = "SELECT product_id, name, brand, description, price, filename 
            FROM product";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product = "product_#" . strval($row["product_id"]);
                $products[$product] = $row;
            }
        }
        else {
            return NULL;
        }
    }
    catch(Exception $e) {
        echo $e->getmessage();
    }
    finally {
        mysqli_close($conn);
    }
    return $products;
}