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
                            <h3>Items</h3>';
        foreach ($_SESSION["cart"] as $key => $value) {
            $product = getProductById($key);
            $subtotal = number_format(($product["price"] * $value), 2, ".", "");
            $total += $subtotal;
            $content .=            '<div class="product_order">
                                        <div class="image">
                                            <a href="index.php?page=detail&product='.$product["product_id"].'" alt="product_link">
                                                <img src="UI/Images/'.$product["filename"].'" alt="picture of product">
                                            </a>
                                        </div>
                                        <div class="text">
                                            <div>
                                                <a href="index.php?page=detail&product='.$product["product_id"].'" alt="product_link">
                                                    <p class="product_name">'.$product["brand"]." ".$product["name"].'</p>
                                                </a>
                                            </div>
                                            ' . showQuantityDropdown($key, $value) . '
                                            <div>
                                                <p>Each</p>
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
                            <hr>
                            <div class="cart_column_2">
                                <h3>Summary</h3>
                                <div>
                                    <p>Total</p>
                                    <p>&euro; '.number_format($total, 2).'</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button class="click_btn checkout" type="button"><a href="index.php?page=checkout">Checkout</a></button>';
        echo $content;
    }
}


/**
 * Display the Empty Cart page 
 */
function showEmptyCart() {
    echo '<h1>Shopping Cart</h1>
          <div class="page_generic">🛒<br>You have no products in your cart</div>';
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


function showOrderThanks() {
    echo '<h1>Thank you</h1>
            <div class="page_generic">
                <div>🛍️<br>Your order was completed successfully</div>
            </div>';  
}