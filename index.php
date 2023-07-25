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
    return $data;
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