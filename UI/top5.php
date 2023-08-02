<?php 

/**
 * Display top 5 product page
 */
function showTop5Page() {
    $top_5 = getTop5();
    echo    '<h1>TOP 5</h1>
            <div class="product_row">';
    foreach ($top_5 as $product_id => $product) {
        echo '<div class="product_column">
                <a href="index.php?page=detail&product='.$product["product_id"].'" alt="product_link">
                    <div class="sold top_5">'.$product["brand"]." ".$product["name"].'</div>
                    <img src="UI/Images/'.$product["filename"].'" alt="picture of product">
                    <div class="sold">'.$product["sold"].' sold<br>last week</div>
        </a>
    </div>';
    }
}