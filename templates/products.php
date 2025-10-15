<div class="container">
  <img src="./public/images/gonzalo-mendiola-JvHhSMttbsY-unsplash.jpg" id="cover-image" alt="">
  <div id="shop-gallery">
      <h2>Shop</h2>
      <div class="shop-gallery-row">
        <?php

          require_once '../src/Product.php';
          $product = new Product();
          echo $product->get_all_products();

        ?>
      </div>
  </div>
</div>
