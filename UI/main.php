<?php

/**
 * Display the HTML document opening tag
 */
function showDocumentStart() {
    echo '<!DOCTYPE html>
          <html>';
}


/**
 * Display the HTML document head section
 * 
 * @param array $data : Relevant page data 
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
 * Display the HTML document body section
 * 
 * @param array $data : Relevant page data
 */
function showBodySection($data) {
    showBodyStart();
    showMenu($data);
    showContent($data);
    showFooter();
    showBodyEnd();
}


/**
 * Display the HTML body opening tag
 */
function showBodyStart() {
    echo '<body>';
}


/**
 * Display the HTML header section
 * 
 * @param array $data : Relevant menu items based on requested page
 */
function showMenu($data) {
    echo   '<header>
                <nav>
                    <ul id="navbar">';
    foreach($data["menu"] as $page_name => $button_text) {
        showMenuItem($page_name, $button_text);
    }
    echo            '</ul>
                </nav>
            </header>';
}


/**
 * Display a menu item 
 * 
 * @param string $page: The requested page
 * @param string $button_text : The text for the menu item button
 */
function showMenuItem($page, $button_text) {
    echo '<li><button type="button"><a class="navlink" href="index.php?page=' . $page . '">' . $button_text . '</a></button></li>';
}


/**
 * Display page content
 * 
 * @param array $data: Relevant page data
 */
function showContent($data) {
    echo '<div class="content">';
    showError($data, "generic");
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
        case "webshop":
            require "UI/webshop.php";
            showWebshopPage($data);
            break;
        default:
            show404Page();
    }
    echo '</div>';
}


/**
 * Display the 404 page content
 */
function show404Page() {
    echo '<h1 id="page_not_found">404 - Page Not Found </h1>';
}


/**
 * Display the HTML document footer section
 */
function showFooter() {
    echo   '<footer>
                <p>Copyright &copy; Quincy 2023</p>
            </footer>';
}


/**
 * Display the HTML document body closing tag
 */
function showBodyEnd() {
    echo    '</body>';
}


/**
 * Display the HTML document closing tag 
 */
function showDocumentEnd() {
    echo '</html>';
}


/**
 * Return boolean to indicate if the request method is POST
 * 
 * @return boolean: TRUE if request method is POST -or- FALSE if not 
 */
function requestMethodIsPost() {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}


/**
 * Get the correct form fields depending on requested page
 * 
 * @return array: The form fields
 */
function getFormFields($page) {
    $fields = array("contact"=>array("gender"=>"","name"=>"","email"=>"","phone"=>"","subject"=>"","communication_preference"=>"","message"=>""),
                    "register"=>array("email"=>"","name"=>"","password"=>"","confirm_password"=>""),
                    "login"=>array("email"=>"","password"=>""),
                    "change_password"=>array("current_password"=>"","new_password"=>"","confirm_new_password"=>""));
    return $fields[$page];
}


/**
 * Get a value from an array
 * 
 * @param array $array: The array
 * @param string $key : The key
 * 
 * @return: Value if this is set -or- empty string
 */
function getArrayValue($data, $key) { 
    return isset($data[$key]) ? $data[$key] : ''; 
}


/**
 * Get a value from the values array
 * 
 * @param array $array: The array
 * @param string $key : The key
 * 
 * @return: Value if this is set -or- empty string
 */
function getValue($data, $key) { 
    return isset($data["values"][$key]) ? $data["values"][$key] : ''; 
}


/**
 * Display an error message 
 * 
 * @param array $data: Data from form validation
 * @param string $key: The key
 * 
 * @return string: Error message(s) if there are error(s) -or- empty string if no errors
 */
function showError($data, $key) {
    if (empty(getArrayValue($data["errors"], $key))) {
        return '';
    }
    else {
        return '<span class="error">* ' . getArrayValue($data["errors"], $key) . '</span>';
    }
}


/**
 * Return POST input
 * 
 * @param string $key: The input key
 */
function getPostValue($key) {
    return isset($_POST[$key]) ? $_POST[$key] : "";
}


/**
 * Display log
 * 
 * @param string $message: The log message
 */
function showLog($message) {
    echo $message;
}