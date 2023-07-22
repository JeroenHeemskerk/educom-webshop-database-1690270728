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
    showDocumentStart();
    showHeadSection($data);
    showBodySection($data);
    showDocumentEnd();
}   


/**
 * Function displays the HTML document start
 */
function showDocumentStart() {
    echo '<!DOCTYPE html>
          <html>';
}


/**
 * Function displays the HTML document head section
 * @param array $data : Relevant user data 
 */
function showHeadSection($data) {
    echo '<head>
            <title>' . ucfirst($data["page"]) . '</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <link rel="stylesheet" href="UI/CSS/stylesheet.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
         </head>';
}


/**
 * Function displays the HTML document body section
 * @param array $data : Relevant user data
 */
function showBodySection($data) {
    showBodyStart();
    showMenu($data);
    showContent($data);
    showFooter();
    showBodyEnd();
}


/**
 * Function displays the HTML document end 
 */
function showDocumentEnd() {
    echo '</html>';
}


/**
 * Function displays the HTML body start
 */
function showBodyStart() {
    echo '<body>';
}


/**
 * Function displays the HTML header section
 * @param array $data : Relevant user data based on requested page
 */
function showMenu($data) {
    echo   '<header>
                <nav>
                    <ul id="navbar">
                        <li><button type="button"><a class="navlink" href="index.php?page=home">Home</a></button></li>
                        <li><button type="button"><a class="navlink" href="index.php?page=about">About Me</a></button></li>
                        <li><button type="button"><a class="navlink" href="index.php?page=contact">Contact</a></button></li>
                        ' . showMenuOption($data) . '
                    </ul>
                </nav>
            </header>';
}


/**
 * Function displays the relevant page content
 * @param array $data : Relevant user data based on requested page
 */
function showContent($data) {
    switch ($data["page"]) {
       case "home":
            require "UI/home.php";
            showHomeContent();
            break;
        case "about":
            require "UI/about.php";
            showAboutContent();
            break;
        case "contact":
            require "UI/contact.php";
            showContactForm($data);
            break;
        case "thanks":
            require "UI/contact.php";
            showContactThanks($data);
            break;
        case "register":
            require "UI/register.php";
            showRegisterPage($data);
            break;
        case "login":
            require "UI/login.php";
            showLoginPage($data);
            break;
        case "change_password":
            require "UI/change_password.php";
            showChangePassword($data);
            break;
        default:
        require "UI/404.php";
            show404Page();
    }
}


/**
 * Function displays the HTML document footer section
 */
function showFooter() {
    echo   '<footer>
                <p>Copyright &copy; Quincy 2023</p>
            </footer>';
}


/**
 * Function displays the HTML document body end
 */
function showBodyEnd() {
    echo    '</body>';
}


/**
 * Function gets a value from a specified array and specified key
 * @param array $array : Array of your choice
 * @param string $key : Key of your choice
 * @return ? : Value if set (can be any type), otherwise returns empty string
 */
function getArrayValue($array, $key) { 
    return isset($array[$key]) ? $array[$key] : ''; 
}


/**
 * Function displays an error message based on specified key
 * @param array $data : Relevant user data
 * @param string $key : Error key
 * @return ? : Value, if set (can be any type), otherwise returns empty string
 */
function getError($data, $key) {
    if (empty(getArrayValue($data["errors"], $key))) {
        return '';
    }
    else {
        return '<span class="error">* ' . getArrayValue($data["errors"], $key) . '</span>';
    }
}


/**
 * Function sets user data inside session variable for use on other pages
 * @param array $data : Relevant user data
 */
function loginUser($data) {
    $_SESSION["data"] = $data;
}


/**
 * Function unsets user data inside session variable
 * @param array $data : Relevant user data
 */
function logoutUser() {
    unset($_SESSION["data"]);
}


/**
 * Function displays relevant navigation links based on if session variable is set
 * @param array $data : Relevant user data
 */
function showMenuOption($data) {
    if (isset($_SESSION["data"])) {
        $data["user"] = $_SESSION["data"]["user"];
        $name = ucfirst(explode(" ", $data["user"]["name"])[0]);
        return '<li><button type="button"><a class="navlink" href="index.php?page=change_password">Change Password</a></button></li>
                <li><button type="button"><a class="navlink" href="index.php?page=logout">Logout ' . $name . '</a></button></li>';
    }
    else {
        return '<li><button type="button"><a class="navlink" href="index.php?page=register">Register</a></button></li>
                <li><button type="button"><a class="navlink" href="index.php?page=login">Login</a></button></li>';
    }
}