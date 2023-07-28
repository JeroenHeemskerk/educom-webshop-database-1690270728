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
    foreach($products as $product => $value) {
        if ($counter % 2 == 0) {
            $content .= '<div class="product_row">
                            <div class="product_column">
                                <a href="index.php?page=detail&product=' . $products[$product]["product_id"] .'" alt="product_link">
                                    <img src="UI/Images/' . $products[$product]["filename"] . '" alt="picture of product">
                                    <div class="brand">' . $products[$product]["brand"] . '</div>
                                    <div class="product_name">' . $products[$product]["name"] . '</div>
                                    <div class="product_price">&euro;' . $products[$product]["price"] . '</div>
                                </a>
                                ' . getAddToCart() . '
                            </div>';
        }
        else {
            $content .= '<div class="product_column">
                            <a href="index.php?page=detail&product=' . $products[$product]["product_id"] .'" alt="product_link">
                                <img src="UI/Images/' . $products[$product]["filename"] . '" alt="picture of product">
                                <div class="brand">' . $products[$product]["brand"] . '</div>
                                <div class="product_name">' . $products[$product]["name"] . '</div>
                                <div class="product_price">&euro;' . $products[$product]["price"] . '</div>
                            </a>
                            ' . getAddToCart() . '
                        </div>
                    </div>';
        }
        $counter += 1;
    }
    return $content;
}