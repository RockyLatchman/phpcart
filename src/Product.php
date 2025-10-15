<?php

class Product {
    function __construct() {
        $this->db = new SQLite3('../data/shoemart.db');
    }

    function get_all_products() {
        $result = $this->db->query('SELECT * FROM product');
        while ($row = $result->fetchArray()):
            echo "<div class='column'>";
            echo "<ul>";
            echo "<li><img src='./public/images/thumbnails/{$row['image']}' alt='\image of ${row['name']}\'></li>";
            echo "<li><a href='/product/{$row['product_id']}'>{$row['name']}<span>&dollar;{$row['price']}</span></a></li>";
            echo "</ul>";
            echo "</div>";
        endwhile;
    }
}
