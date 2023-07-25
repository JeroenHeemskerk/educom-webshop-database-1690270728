<?php

/**
 * Function sets user data inside session variable for use on other pages
 * @param array $data : Relevant user data
 */
function loginUser($data) {
    $_SESSION["data"] = $data;
}

/**
 * Function returns boolean to indicate if user is logged in or not
 * @return boolean : User logged in
 */
function isUserLoggedIn() {
    return isset($_SESSION["data"]);
}


/**
 * Function returns user data array
 * @return array : User data stored in Session (id, email, name, password)
 */
function getLoggedInUser() {
    return $_SESSION["data"]["user"];
}


/**
 * Function returns user name 
 * @return string : User name stored in Session (id, email, name, password)
 */
function getLoggedInUserName() {
    return $_SESSION["data"]["user"]["name"];
}


/**
 * Function unsets user data inside session variable
 * @param array $data : Relevant user data
 */
function logoutUser() {
    unset($_SESSION["data"]);
}