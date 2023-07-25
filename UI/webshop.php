<?php 

function showWebshopPage($data) {
    require "data_manipulation.php";
    $products = getProducts();
    echo '  <div class="content">
                <h1>Webshop</h1>
                <div class="product_row">   
                    ' . showProducts($products) . '
                </div>
            </div>';
}


function showProducts($products) {
    $content = "";
    foreach($products as $product => $value) {
        $content .= '<div class="product_column">
                        <img src="UI/Images/' . $products[$product]["filename"] . '" alt="picture of product">
                        <div class="brand">' . $products[$product]["brand"] . '</div>
                        <div class="product_name">' . $products[$product]["name"] . '</div>
                        <div class="product_price">&euro;' . $products[$product]["price"] . '</div>
                        ' . getAddToCart() . '
                    </div>';
        
    }
    return $content;
}

function getAddToCart() {
    if (isUserLoggedin()) {
        return '<button type="button" class="add_to_cart">Add to Cart</button>';
    }
    else {
        return '';
    }
}

// getShoppingCart() {

// }