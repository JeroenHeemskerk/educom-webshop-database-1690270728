<?php 


/**
 * Display webshop page
 */
function showWebshopPage() {
    $products = getProducts();
    echo    '<h1>Webshop</h1>
                ' . showProducts($products);
}


/**
 * Display products on webshop page
 * 
 * @param array $products: The products array
 */
function showProducts($products) {
    $content = "";
    $counter = 0;
    foreach($products as $id => $product) {
        if ($counter % 2 == 0) {
            $content .= '<div class="product_row">
                            <div class="product_column">
                                <a href="index.php?page=detail&product=' . $product["product_id"] .'" alt="product_link">
                                    <img src="UI/Images/' . $product["filename"] . '" alt="picture of product">
                                    <div class="brand">' . $product["brand"] . '</div>
                                    <div class="product_name">' . $product["name"] . '</div>
                                    <div class="product_price">&euro;' . $product["price"] . '</div>
                                </a>
                                ' . getAddToCartWebshop($product["product_id"]) . '
                            </div>';
        }
        else {
            $content .=    '<div class="product_column">
                                <a href="index.php?page=detail&product=' . $product["product_id"] .'" alt="product_link">
                                    <img src="UI/Images/' . $product["filename"] . '" alt="picture of product">
                                    <div class="brand">' . $product["brand"] . '</div>
                                    <div class="product_name">' . $product["name"] . '</div>
                                    <div class="product_price">&euro;' . $product["price"] . '</div>
                                </a>
                                ' . getAddToCartWebshop($product["product_id"]) . '
                            </div>
                        </div>';
        }
        $counter++;
    }
    return $content;
}