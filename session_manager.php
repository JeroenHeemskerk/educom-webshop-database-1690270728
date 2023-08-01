<?php

/**
 * Set user data inside session variable for use on other pages
 * 
 * @param array $data: User data
 */
function loginUser($data) {
    $_SESSION["user_name"] = $data["user"]["name"];
    $_SESSION["user_id"] = $data["user"]["user_id"];
}

/**
 * Return boolean to indicate if user is logged in or not
 * 
 * @return boolean: TRUE if user is logged in -or- FALSE if not logged in
 */
function isUserLoggedIn() {
    return isset($_SESSION["user_name"]);
}


/**
 * Return user ID
 * 
 * @return int: User ID
 */
function getLoggedInUserId() {
    return $_SESSION["user_id"];
}


/**
 * Return user name 
 * 
 * @return string: User name 
 */
function getLoggedInUserName() {
    return $_SESSION["user_name"];
}


/**
 * Unset user data inside session variable
 */
function logoutUser() {
    unset($_SESSION["user_name"]);
    unset($_SESSION["user_id"]);
}


function addToCart($product_id, $amount=1) {
    if (isset($_SESSION["cart"])) {
        $_SESSION["cart"][$product_id] = $amount;
    }
    else {
        $_SESSION["cart"] = array();
        $_SESSION["cart"][$product_id] = $amount;
    }
}