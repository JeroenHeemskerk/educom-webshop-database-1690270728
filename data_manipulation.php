<?php 

/**
 * Connect to database
 * 
 * @return object $conn : Connection to the database
 * 
 * @throws Exception: When unable to connect to database
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
 * Insert user data in database
 * 
 * @param string $email: The user email
 * @param string $name: The user name
 * @param string $password: The user password
 * 
 * @throws Exception: When unable to interact with database
 */
function storeUser($email, $name, $password) {
    $conn = connectToDatabase();
    $email = mysqli_real_escape_string($conn, $email);
    $name = mysqli_real_escape_string($conn, $name);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "INSERT INTO `user` (`email`, `name`, `password`)
            VALUES ('$email', '$name', '$password');";

    try {
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to store user data: " . mysql_error($conn));
        }
    }
    finally {
        mysqli_close($conn);
    }
    
}


/**
 * Find user data by email
 * 
 * @param string $email: The user email
 * 
 * @return: User data if exists -or- NULL
 * 
 * @throws Exception: When unable to interact with database
 */
function findUserByEmail($email) {
    $conn = connectToDatabase();
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT `user_id`, `email`, `name`, `password` 
            FROM `user`
            WHERE `email` = '$email';";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["email"] == $email) {
                    return $row;
                }
            }
        }
    }
    finally {
        mysqli_close($conn);
    }
}


/**
 * Find user data by ID
 * 
 * @param string $user_id: The user ID
 * 
 * @return: User data if exists -or- NULL
 * 
 * @throws Exception: When unable to interact with database
 */
function findUserById($user_id) {
    $conn = connectToDatabase();
    $user_id = mysqli_real_escape_string($conn, $user_id);

    $sql = "SELECT `user_id`, `email`, `name`, `password` 
            FROM `user`
            WHERE `user_id` = '$user_id';";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["user_id"] == $user_id) {
                    return $row;
                }
            }
        }
    }
    finally {
        mysqli_close($conn);
    }
}


/**
 * Update user password in database
 * 
 * @param string $user_id: The user ID
 * @param string $new_password: The new user password
 * 
 * @throws Exception: When unable to interact with database
 */
function updatePassword($user_id, $new_password) {
    $conn = connectToDatabase();
    $id = mysqli_real_escape_string($conn, $user_id);
    $new_password = mysqli_real_escape_string($conn, $new_password);

    $sql = "UPDATE `user`
            SET `password` = '$new_password'
            WHERE `user_id` = $id;";
    try {
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to update user data: " . mysql_error($conn));
        }
    }
    finally {
        mysqli_close($conn);
    }
    
}


/**
 * Get products from database
 * 
 * @return array $products: The products in database
 * 
 * @throws Exception: When unable to interact with database
 */
function getProducts() {
    $conn = connectToDatabase();
    $products = array();
    $sql = "SELECT `product_id`, `name`, `brand`, `description`, `price`, `filename` 
            FROM `product`;";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[$row["product_id"]] = $row;
            }
        }
        return $products;
    }
    finally {
        mysqli_close($conn);
    }
}


/**
 * Find product by product id 
 * 
 * @param string $product_id: The product id
 * 
 * @return array $product: The product in database
 * 
 * @throws Exception: When unable to interact with database
 */
function getProductById($product_id) {
    $conn = connectToDatabase();
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $sql = "SELECT `name`, `brand`, `description`, `price`, `filename` 
            FROM `product`
            WHERE `product_id` = '$product_id';";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select user data: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["product_id"] = $product_id) {
                    return $row;
                }
            }
        }
    }
    finally {
        mysqli_close($conn);
    }
}


function storeOrder($user_id) {
    $conn = connectToDatabase();
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "INSERT INTO `order` (`date`, `user_id`) 
            VALUES (current_timestamp(), '$user_id');";

    try {
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to store order: " . mysql_error($conn));
        }
    }
    finally {
        mysqli_close($conn);
    }
}

function getLastOrderId($user_id) {
    $conn = connectToDatabase();
    $user_id = mysqli_real_escape_string($conn, $user_id);

    $sql = "SELECT `order_id`, `user_id`
            FROM `order`
            WHERE `user_id` = '$user_id'
            ORDER BY `order_id` DESC
            LIMIT 1;";

    try {
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            throw new Exception("<br>Failed to select last order ID: " . mysql_error($conn));
        }
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["user_id"] == $user_id) {
                    return $row["order_id"];
                }
            }
        }
    }
    finally {
        mysqli_close($conn);
    }
}

function insertProductOrder($product_id, $order_id, $quantity) {
    $conn = connectToDatabase();
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $order_id = mysqli_real_escape_string($conn, $order_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);

    $sql = "INSERT INTO `product_order` (`product_id`, `order_id`, `quantity`)
            VALUES ('$product_id', '$order_id', '$quantity');";

    try {
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("<br>Failed to store product order: " . mysql_error($conn));
        }
    }
    finally {
        mysqli_close($conn);
    }
}