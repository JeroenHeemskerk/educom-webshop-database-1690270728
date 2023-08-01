<?php

function showDetailPage($product) {
    echo '  <h1>Detail</h1>
            <div class="detail_row">
                <div class="detail_column">
                    <img src="UI/Images/' . $product["filename"] . '" alt="Picture of product">
                </div>
                <div class="detail_column">
                    <div class="brand">' . $product["brand"] . '</div>
                    <div class="product_name">' . $product["name"] . '</div>
                    <div class="product_price">&euro;' . $product["price"] . '</div>
                    ' . getAddToCart($product["product_id"]) . '
                </div>
            </div>
            <div class="detail_row">
                <div class="detail_column">
                    <h4>Description</h4>
                    <p>' . $product["description"] . '</p>
                </div>
            </div>';
}