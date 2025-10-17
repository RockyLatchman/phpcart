<?php
declare(strict_types=1);

class Product {
    function __construct() {
        $this->db = new SQLite3('../data/shoemart.db');
    }

    public function get_all_products() {
        $result = $this->db->query('SELECT * FROM product');
        while ($row = $result->fetchArray()):
            echo "<div class='column'>";
            echo "<ul>";
            echo "<li><img src='./public/images/thumbnails/{$row['thumbnail']}' alt='\image of ${row['name']}\'></li>";
            echo "<li><a href='/shoemart/?page=product&id={$row['product_id']}'>{$row['name']}
            <span>&dollar;{$this->price_converter(intval($row['price']))}</span></a></li>";
            echo "</ul>";
            echo "</div>";
        endwhile;
    }

    public function get_product($product_id){
        $product = $this->db->prepare('SELECT * FROM product WHERE product_id= :product_id');
        $product->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
        $result = $product->execute();
        if ($result):
            while ($row = $result->fetchArray(SQLITE3_ASSOC)):
                $price = $this->price_converter(intval($row['price']));
                echo '<div class="product-container">';
                echo '<div class="product">';
                echo '<div>';
                echo '<a href="/shoemart/">Back to products</a>';
                echo '<br>';
                echo "<img src='./public/images/{$row['image']}' alt='image of {$row['name']}'>";
                echo '</div>';

                echo '<div>';
                echo "<h3>{$row['name']}</h3>";
                echo "<p>&dollar;{$price}</p>";
                echo '<p>Size</p>';
                echo '<p>Quantity</p>';
                echo '<ul>';
                echo '<li><button>&minus;</button></li>';
                echo '<li id="quantity">1</li>';
                echo '<li><button>&plus;</button></li>';
                echo '</ul>';
                echo '<p id="producty-description">Product Description</p>';
                echo "<p>{$row['description']}</p>";
                echo '<ul>';
                echo '<li><button id="add">Add to Cart</button></li>';
                echo '<li><button id="buy">Buy Now</button></li>';
                echo '</ul>';
                echo '</div>';

                echo '</div>';
                echo '<div>';
           endwhile;
        endif;
    }

    private function get_product_size($product_id){
        //Takes the product_id and returns all the available sizes

    }

    private function price_converter(int $product_price): int {
        //Convert cents to dollars
        return intval($product_price / 10.0);
    }
}
