<?php

include_once('../templates/header.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'products';

switch($page):
   case 'product':
      include_once('../templates/product.php');
      break;
   case 'cart':
      include_once('../templates/cart.php');
      break;
   case 'checkout':
      include_once('../templates/checkout.php');
      break;
   case 'confirmation':
      include_once('../templates/confirmation.php');
      break;
   default:
      include_once('../templates/products.php');
endswitch;



?>
