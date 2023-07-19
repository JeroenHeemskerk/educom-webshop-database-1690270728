<?php

session_start();

$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

function getRequestedPage() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $page = $_POST["page"];
    }
    else {
        $page = isset($_GET["page"]) ? $_GET["page"] : "home";
    }
    return $page;
}

function processRequest($page) {
    switch($page) {
        case "contact":
            require "validations.php";
            $data = validateContact();
            if ($data["valid"]) {
                $page = "thanks";
            }
            break;
        case "register":
            require "validations.php";
            $data = validateRegister();
            if ($data["valid"]) {
                saveUser($data);
                $page = "login";
            }
            break;
        case "login":
            require "validations.php";
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
        }
    $data["page"] = $page;
    return $data;

}

function showResponsePage($data) {
    showDocumentStart();
    showHeadSection($data);
    showBodySection($data);
    showDocumentEnd();
}   

function showDocumentStart() {
    echo '<!DOCTYPE html>
          <html>';
}

function showHeadSection($data) {
    echo '<head>
            <title>' . ucfirst($data["page"]) . '</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
            <link rel="stylesheet" href="CSS/stylesheet.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
         </head>';
}

function showBodySection($data) {
    showBodyStart();
    showMenu($data);
    showContent($data);
    showFooter();
    showBodyEnd();
}

function showDocumentEnd() {
    echo '</html>';
}

function showBodyStart() {
    echo '<body>';
}

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

function showContent($data) {
    switch ($data["page"]) {
       case "home":
            require "home.php";
            showHomeContent();
            break;
        case "about":
            require "about.php";
            showAboutContent();
            break;
        case "contact":
            require "contact.php";
            showContactForm($data);
            break;
        case "thanks":
            require "contact.php";
            showContactThanks($data);
            break;
        case "register":
            require "register.php";
            showRegisterPage($data);
            break;
        case "login":
            require "login.php";
            showLoginPage($data);
            break;
        default:
        require "404.php";
            show404Page();
    }
}

function showFooter() {
    echo   '<footer>
                <p>Copyright &copy; Quincy 2023</p>
            </footer>';
}

function showBodyEnd() {
    echo    '</body>';
}

function getArrayValue($array, $key, $default='') { 
    return isset($array[$key]) ? $array[$key] : $default; 
}

function showFormError($data, $key) {
    if (empty(getArrayValue($data["errors"], $key))) {
        return '<span class="error">' . getArrayValue($data["errors"], $key) . '</span>';
    }
    else {
        return '<span class="error">* ' . getArrayValue($data["errors"], $key) . '</span>';
    }
}

function loginUser($data) {
    $_SESSION["data"] = $data;
}

function logoutUser() {
    unset($_SESSION["data"]);
}

function showMenuOption($data) {
    if (isset($_SESSION["data"])) {
        $data["user"] = $_SESSION["data"]["user"];
        $name = ucfirst(explode(" ", $data["user"]["name"])[0]);
        return '<li><button type="button"><a class="navlink" href="index.php?page=logout">Logout ' . $name . '</a></button></li>';
    }
    else {
        return '  <li><button type="button"><a class="navlink" href="index.php?page=register">Register</a></button></li>
                <li><button type="button"><a class="navlink" href="index.php?page=login">Login</a></button></li>';
    }
}