<?php 

function showWebshopPage($data) {
    require "data_manipulation.php";
    $products = getProducts();
    echo '  <div class="content">
                <h1>Webshop</h1>
                ' . showProducts($products) . '
            </div>';
}


function showProducts($products) {
    $content = "";
    $counter = 0;
    foreach($products as $product => $value) {
        if ($counter % 2 == 0) {
            $content .= '<div class="product_row">
                            <div class="product_column">
                                <img src="UI/Images/' . $products[$product]["filename"] . '" alt="picture of product">
                                <div class="brand">' . $products[$product]["brand"] . '</div>
                                <div class="product_name">' . $products[$product]["name"] . '</div>
                                <div class="product_price">&euro;' . $products[$product]["price"] . '</div>
                                ' . getAddToCart() . '
                            </div>
                        ';
        }
        else {
            $content .= '<div class="product_column">
                            <img src="UI/Images/' . $products[$product]["filename"] . '" alt="picture of product">
                            <div class="brand">' . $products[$product]["brand"] . '</div>
                            <div class="product_name">' . $products[$product]["name"] . '</div>
                            <div class="product_price">&euro;' . $products[$product]["price"] . '</div>
                            ' . getAddToCart() . '
                        </div>
                    </div>';
        }
        $counter += 1;
    }
    return $content;
}

function getAddToCart() {
    if (isUserLoggedin()) {
        return '<button type="button" class="click_btn cart">Add to Cart</button>';
    }
    else {
        return '';
    }
}

// getShoppingCart() {

// }