<?php 

/**
 * Display top 5 product page
 */
function showTop5Page() {
    $top_5 = getTop5();
    $content =    '<h1>TOP 5</h1>
                   <h3>Most sold products last week</h3>
                  <div class="top5_container">
                   <div class="product_row">';
    foreach ($top_5 as $product_id => $product) {
        $content .= '<div class="product_column">
                        <a href="index.php?page=detail&product='.$product["product_id"].'" alt="product_link">
                            <div class="sold top_5">'.$product["brand"]." ".$product["name"].'</div>
                            <img src="UI/Images/'.$product["filename"].'" alt="picture of product">
                            <div class="sold">'.$product["sold"].' sold<br>last week</div>
                        </a>
                    </div>';
    }
    $content .= '</div>
                </div>';
    echo $content;
}