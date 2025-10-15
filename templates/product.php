<div class="container">
 <?php
    require_once '../src/Product.php';
    $product = new Product();
    if(isset($_GET['id'])):
       $product->get_product($_GET['id']);
    else:
       echo '<p>No product</p>';
    endif;
  ?>
</div>
