<?php

require "session_manager.php";
require "validations.php";
require "data_manipulation.php";
require "UI/main.php";

session_start();
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);


/**
 * Get the requested page
 * 
 * @return string $page : The requested page
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
 * Process the page requests
 * 
 * @return array $data : Relevant page data
 */
function processRequest($page) {
    $data["errors"] = array();
    switch($page) {
        case "contact":
            $data = validateContact($page);
            if ($data["valid"]) {
                $page = "thanks";
            }
            break;
        case "register":
            $data = validateRegister($page);
            if ($data["valid"]) {
                storeUser($data["values"]["email"],$data["values"]["name"],$data["values"]["password"]);
                $page = "login";
            }
            break;
        case "login":
            $data = validateLogin($page);
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
            $data = validateNewPassword($page);
            if ($data["valid"]) {
                updatePassword($data["user"]["user_id"], $data["values"]["new_password"]);
                $page = "home";
            }
            break;
        case "webshop":
            if (requestMethodIsPost()) {
                $product_id = getPostValue("product_id");
                addToCart($product_id);
            }
            break;
        case "detail":
            $product_id = getRequestedProductId();
            if (doesProductExist($product_id)) {
                $data["product"] = getProductById($product_id);
            }
            if (requestMethodIsPost()) {
                $product_id = getPostValue("product_id");
                addToCart($product_id);
            }
            break;
        case "cart":
            if (requestMethodIsPost()) {
                $product_id = getPostValue("product_id");
                $quantity = getPostValue("quantity");
                addToCart($product_id, $quantity);
            }
            break;
        case "checkout":
            $data = validateCheckout();
            if ($data["valid"]) {
                emptyCart();
                $page = "order";
            }
            break;
    }
    $data["page"] = $page;
    $data["menu"] = getMenuItems();
    return $data;
}


/**
 * Get the requested product
 * 
 * @return string: The requested product
 */
function getRequestedProductId() {
    if (isset($_GET["product"]) && $_GET["product"] != "") {
        return  $_GET["product"];
    }
}


/**
 * Display the response page
 * 
 * @param array $data : Relevant page data
 */
function showResponsePage($data) {
    showDocumentStart();
    showHeadSection($data);
    showBodySection($data);
    showDocumentEnd();
}