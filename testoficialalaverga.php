<?php

include('lists/NoMode/ps_product_shop.php');
include('lists/NoMode/ps_stock_available.php');
include('lists/NoMode/ps_product.php');

echo "<style>table {width:50%; background:#999;} td{width:30%; border-collapse:collapse; border:1px solid #000;}</style>";
for($i=0;$i<count($ps_product_shop);$i++){
  $id = $ps_product_shop[$i]['id_product'];
  $reference = $ps_product[$i]['reference'];
  $price = $ps_product[$i]['price'];
  echo "<table border=0>";
  echo "  <tr>";
  echo "    <td>".$reference."</td>";
  echo "    <td>".$price."</td>";
  echo "  </tr>";
  echo "</table>";
}


# ps_product_shop && ps_product
# [i]['id_product']
# [i]['reference']
# [i]['price']

# ps_stock_available
# [i]['quantity']
