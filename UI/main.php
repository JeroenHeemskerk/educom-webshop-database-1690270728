<?php


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
                    <ul id="navbar">';
    foreach($data["menu"] as $page_name => $button_text) {
        showMenuItem($page_name, $button_text);
    }
    echo            '</ul>
                </nav>
            </header>';
}


/**
 * Function echos a menu item button
 * @param string $page_name : Page name for navigation link
 * @param string $button_text : Text for button
 */
function showMenuItem($page_name, $button_text) {
    echo '<li><button type="button"><a class="navlink" href="index.php?page=' . $page_name . '">' . $button_text . '</a></button></li>';
}


/**
 * Function displays the relevant page content
 * @param array $data : Relevant user data based on requested page
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
 * Function that displays the '404 page' content
 */
function show404Page() {
    echo '<h1 id="page_not_found">404 - Page Not Found </h1>';
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
 * Function gets the value from the $data["values"] array for the specified key
 * @param array $data [
 *                  "values" => array : User data submitted ]
 * @param string $key : Key of your choice
 * @return ? : Value if set (can be any type), otherwise returns empty string
 */
function getValue($data, $key) { 
    return isset($data["values"][$key]) ? $data["values"][$key] : ''; 
}


/**
 * Function displays an error message based on specified key
 * @param array $data : Relevant user data
 * @param string $key : Error key
 * @return ? : Value, if set (can be any type), otherwise returns empty string
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
 * Function displays the HTML document end 
 */
function showDocumentEnd() {
    echo '</html>';
}