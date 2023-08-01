<?php 

/**
 * Display the Shopping Cart page 
 */
function showShoppingCartPage() {
    if (!isset($_SESSION["cart"])) {
        showEmptyCart();
    }
    else {
        $content = "";
        $total = 0;
        $content .=    '<h1>Shopping Cart</h1>
                        <div class="cart_row">
                            <div class="cart_column_1">
                            <h4>Items</h4>';
        foreach ($_SESSION["cart"] as $key => $value) {
            $product = getProductById($key);
            $subtotal = number_format(($product["price"] * $value), 2, ".", "");
            $total += $subtotal;
            $content .=            '<div class="product_order">
                                        <div class="image">
                                            <img src="UI/Images/' . $product["filename"] . '" alt="picture of product">
                                        </div>
                                        <div class="text">
                                            <div>
                                                <p class="product_name">'.$product["brand"]." ".$product["name"].'</p>
                                            </div>
                                            ' . showQuantityDropdown($key, $value) . '
                                            <div>
                                                <p>Price</p>
                                                <p class="product_price">&euro;' . $product["price"] . '</p>
                                            </div>
                                            <div>
                                                <p>Subtotal</p>
                                                <p class="product_price">&euro;' . $subtotal . '</p>
                                            </div>
                                        </div>
                                    </div>';
        }  
        $content .=         '</div>
                            <div class="cart_column_2">
                                <h3>Summary</h3>
                                <div>
                                    <p>Total</p>
                                    <p>&euro; '.number_format($total, 2).'</p>
                                </div>
                            </div>
                    </div>';
    }
    echo $content;
}


/**
 * Display the Empty Cart page 
 */
function showEmptyCart() {
    echo '<h1 class="page_generic">🛒<br>You have no products in your cart</h1>';
}


/**
 * Display the quantity dropdown menu for product order
 * 
 * @param string $product_id: The ID of product
 * @param string $amount: The amount of product
 * 
 * @return string $dropdown: The quantity dropdown menu 
 */
function showQuantityDropdown($product_id, $amount) {
    $dropdown = '<div>
                    <form id="cart_form" action="" method="POST">
                        <input type="hidden" name="page" value="cart">
                        <input type="hidden" name="product_id" value="'.$product_id.'">
                        <label for="quantity">Quantity</label> 
                        <select id="quantity" name="quantity" onchange="this.form.submit()">
                            <option value="'.$amount.'">'.$amount.'</option>';
    for ($quantity = 0; $quantity <= 10; $quantity++) {
        $dropdown .=   '<option value="'.$quantity.'">'.$quantity.'</option>';
    }
    $dropdown .= '</select>
                  </form>
                  </div>';
    return $dropdown;
}