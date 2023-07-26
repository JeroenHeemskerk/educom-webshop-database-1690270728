<?php

require "session_manager.php";
require "validations.php";
require "data_manipulation.php";

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
    $data["errors"] = array();
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
                $data = runQuery("storeUser", $data);
                if ($data["valid"]) {
                    $page = "login";
                }
            }
            break;
        case "login":
            $data = validateLogin();
            if ($data["valid"]) {
                loginUser($data);
                $page = "home";
            }
            break;
        case "logout":
            logoutUser();
            $page = "home";
            break;
        case "change_password":
            $data = validateNewPassword();
            if ($data["valid"]) {
                $data = runQuery("updatePassword", $data);
                if ($data["valid"]) {
                    $page = "home";
                }
            }
            break;
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
    if (isUserLoggedIn()) {
        $firstname = ucfirst(explode(" ", getLoggedInUserName())[0]);
        $menu = array("home"=>"Home","about"=>"About","contact"=>"Contact","change_password"=>"Change Password","logout"=>"Logout ".$firstname,"webshop"=>"Webshop");
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
 * Function echoes message that's supposed to be recorded in log
 */
function showLog($message) {
    echo $message;
}