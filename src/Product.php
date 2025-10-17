<?php
declare(strict_types=1);

class Product {
    function __construct() {
        $this->db = new SQLite3('../data/shoemart.db');
    }

    public function get_all_products(): string {
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

    public function get_product(int $product_id)  {
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
                echo '<form method="POST">';
                echo "<h3>{$row['name']}</h3>";
                echo "<p>&dollar;{$price}</p>";
                echo '<p>Size</p>';
                $this->get_product_size($row['product_id']);
                echo '<p>Quantity</p>';
                echo '<ul>';
                echo '<li><button id="remove-button">&minus;</button></li>';
                echo '<li id="quantity">1</li>';
                echo '<li><button id="add-button">&plus;</button></li>';
                echo '</ul>';
                echo '<p id="product-description">Product Description</p>';
                echo "<p>{$row['description']}</p>";
                echo '<ul>';
                echo '<li><button id="add">Add to Cart</button></li>';
                echo '<li><button id="buy">Buy Now</button></li>';
                echo '</ul>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '<div>';
           endwhile;
        endif;
    }

    private function get_product_size(int $product_id) {
       //Takes the product_id and returns all the available sizes
        $products = $this->db->prepare('SELECT * FROM product_size WHERE product_id= :product_id');
        $products->bindValue(':product_id', $product_id, SQLITE3_INTEGER);
        $result = $products->execute();
        echo '<select name="shoe-size">';
        while ($row = $result->fetchArray(SQLITE3_ASSOC)):
          echo '<option value="' . $this->shoe_size_converter($row['size']) . '">' . $this->shoe_size_converter($row['size']) . '</option>';
        endwhile;
        echo '</select>';
    }

    private function price_converter(int $product_price): int {
        //Convert cents to dollars
        return intval($product_price / 10.0);
    }

    private function shoe_size_converter($shoe_size) {
        /* Convert integer to string and if the number of
          characters  are greater than 2 or the last character
           is 5 than it is half of a shoe size
        */
        $number_characters = (string) $shoe_size;
        if (strlen($number_characters) > 2 || substr($number_characters, -1) == 5):
            return $shoe_size * 00.1;
        endif;
        return $shoe_size;
    }
}
