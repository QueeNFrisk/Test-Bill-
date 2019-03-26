<?php

require 'vendor/autoload.php';

//include 'latch.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$TAXE_DEFAULT = round('1.16',2);
$INTERAL_CURRENCY = round('19.70', 2);
$EXTERNAL_CURRENCY = round('20.00', 2);
$HIGH_GAN = round('1.1', 2);
$MEDIUM_GAN = round('1.20', 2);
$MEDIUMLOW_GAN = round('1.30', 2);
$LOW_GAN = round('1.5', 2);

$db = new mysqli('localhost', 'root', '', 'prestashop');
$list = __DIR__ . '/lists/Arroba.xlsx';

$list = IOFactory::load($list);
$list = $list->getActiveSheet()->toArray(null, true, true, true);
//$list = json_encode($list);
for($i = 1; $i <= count($list); $i++){
  $a_ar = $list[$i]["A"]; # Referencia
  $b_ar = $list[$i]["B"]; # Nombre
  $c_ar = $list[$i]["C"]; # Moneda
  $d_ar = $list[$i]["D"]; # CEN
  $e_ar = $list[$i]["E"]; # CEDIS
  $f_ar = $list[$i]["F"]; # GDL
  $g_ar = $list[$i]["G"]; # Precio
  $h_ar_t = round($g_ar, 2);
  $h_ar_ti = round($h_ar_t * $INTERAL_CURRENCY, PHP_ROUND_HALF_UP);
  if($h_ar_ti <= 2){
    $h_ar_tig = round(9999.1 * $HIGH_GAN, PHP_ROUND_HALF_UP);
  }elseif($h_ar_ti > 2 && $h_ar_ti < 300){
    $h_ar_tig = round($h_ar_ti * $LOW_GAN, PHP_ROUND_HALF_UP);
  }elseif($h_ar_ti > 301 && $h_ar_ti < 500){
    $h_ar_tig = round($h_ar_ti * $MEDIUMLOW_GAN, PHP_ROUND_HALF_UP);
  }elseif($h_ar_ti > 501 && $h_ar_ti < 900){
    $h_ar_tig = round($h_ar_ti * $MEDIUM_GAN, PHP_ROUND_HALF_UP);
  }elseif($h_ar_ti > 901){
    $h_ar_tig = round($h_ar_ti * $HIGH_GAN, PHP_ROUND_HALF_UP);
  }
  $h_ar_tigf = round($h_ar_tig / $EXTERNAL_CURRENCY, PHP_ROUND_HALF_UP);
  $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference = "'.$a_ar.'"');
  $conslt_pe->fetch_array(MYSQLI_ASSOC);
  var_dump($conslt_pe);
  #$price = $db->query('UPDATE ps_product_shop SET price = "'.$h_ar_tigf.'" WHERE id_product = "'.$a_ar.'"');
  #$stock_get = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$a_ar.'"');
  #$stock_get = $stock_get->fetch_array(MYSQLI_ASSOC);

  #$stock_get = $stock_get['quantity'] + $f_ar;
  //print_r($a_ar." || ".$stock_get." || ".$f_ar."<br/>");

  #$stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get.'" WHERE id_product = "'.$a_ar.'"');
}

/*$a_ar = str_replace('"', " ", str_replace("/", " ", $show["A"])); // Referencia
$b_ar = str_replace('"', " ", str_replace("/", " ", $show["B"])); // Nombre
$c_ar = str_replace('"', " ", str_replace("/", " ", $show["C"])); // Moneda
$d_ar = str_replace('"', " ", str_replace("/", " ", $show["D"])); // CEN
$e_ar = str_replace('"', " ", str_replace("/", " ", $show['E'])); // CEDIS
$f_ar = str_replace('"', " ", str_replace("/", " ", $show['F'])); // GDL
$g_ar = str_replace('"', " ", str_replace("/", " ", $show['G']));// Precio Original*/
