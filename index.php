<?php

session_start();
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);


/**
 * Function gets the requested page, via POST or GET method
 * @return string $page : Requested page
 */
function getRequestedPage() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $page = $_POST["page"];
    }
    else {
        $page = isset($_GET["page"]) ? $_GET["page"] : "home";
    }
    return $page;
}


/**
 * Function processes the page requests
 * @return array $data : Relevant user data
 */
function processRequest($page) {
    require "validations.php";
    switch($page) {
        case "contact":
            $data = validateContact();
            if ($data["valid"]) {
                $page = "thanks";
            }
            break;
        case "register":
            $data = validateRegister();
            if ($data["valid"]) {
                storeUser($data);
                $page = "login";
            }
            break;
        case "login":
            $data = validateLogin();
            if ($data["valid"]) {
                $page = "home";
                loginUser($data);
            }
            break;
        case "logout":
            logoutUser();
            $page = "home";
            break;
        case "change_password":
            $data = validateNewPassword();
            if ($data["valid"]) {
                updatePassword($data);
                $page = "home";
                break;
            }
        }
    $data["page"] = $page;
    $data["menu"] = getMenuItems();
    return $data;
}


/**
 * Function returns the right navigation menu items, based on if user is logged in or not
 * @return array $menu [
 *                  "page_name" => string : Button text ]
 */
function getMenuItems() {
    if (isUserLoggedin()) {
        $data["user"] = $_SESSION["data"]["user"];
        $name = ucfirst(explode(" ", $data["user"]["name"])[0]);
        $menu = array("home"=>"Home","about"=>"About","contact"=>"Contact","change_password"=>"Change Password","logout"=>"Logout ".$name,"webshop"=>"Webshop");
    }
    else {
        $menu = array("home"=>"Home","about"=>"About","contact"=>"Contact","register"=>"Register","login"=>"Login","webshop"=>"Webshop");
    }
    return $menu;
}


/**
 * Function displays the response page
 * @param array $data : Relevant user data
 */
function showResponsePage($data) {
    require "UI/main.php";
    showDocumentStart();
    showHeadSection($data);
    showBodySection($data);
    showDocumentEnd();
}   


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
function isUserLoggedin() {
    return isset($_SESSION["data"]);
}


/**
 * Function unsets user data inside session variable
 * @param array $data : Relevant user data
 */
function logoutUser() {
    unset($_SESSION["data"]);
}