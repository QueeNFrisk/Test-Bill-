<?php

//error_reporting(1);

require 'vendor/autoload.php';

//include 'latch.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

set_time_limit(500);

class listsUpdate {
  function arroba_update(){
    $TAXE_DEFAULT = round('1.16',2);
    $INTERAL_CURRENCY = round('19.70', 2);
    $EXTERNAL_CURRENCY = round('20', 2);
    $HIGH_GAN = round('1.1', 2);
    $MEDIUM_GAN = round('1.20', 2);
    $MEDIUMLOW_GAN = round('1.30', 2);
    $LOW_GAN = round('1.5', 2);

    $db = new mysqli('localhost', 'root', '', 'prestashop');

    $arroba = __DIR__ . '/Lists/Arroba.xlsx';
    // __ARROBA IMPORT TO JSON -> EXPORT TO MYSQL
    $arroba_sheet = IOFactory::load($arroba);
    $arroba_sheet = $arroba_sheet->getActiveSheet()->toArray(null, true, true, true);
    for($i = 1; $i <= count($arroba_sheet)-1; $i++){

      $a_ar = str_replace('"', " ", str_replace("/", " ", $arroba_sheet[$i]["A"]));
      ob_flush();
      $b_ar = $arroba_sheet[$i]["B"];
      $c_ar = $arroba_sheet[$i]["C"];
      $d_ar = $arroba_sheet[$i]["D"];
      $e_ar = $arroba_sheet[$i]["E"];
      $f_ar = $arroba_sheet[$i]["F"];
      $g_ar = $arroba_sheet[$i]["G"];

      if($d_te = "Dolares"){
        $h_ar_t = round($g_ar, 2);
        $h_ar_ti = round($h_ar_t * $INTERAL_CURRENCY, PHP_ROUND_HALF_UP);
        if($h_ar_ti <= 2){
          $h_ar_tig = round(9999.1 * $HIGH_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 2 && $h_ar_ti < 300){
          $h_ar_tig = round($h_ar_ti * $LOW_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 301 && $h_ar_ti < 500){
          $h_ar_tig = round($h_ar_ti * $MEDIUMLOW_GAN, PHP_ROUND_HALF_UP);
        }elseif(number_format($h_ar_ti, 2) > 501 && round(number_format($h_ar_ti, 2)) < 900){
          $h_ar_tig = round($h_ar_ti * $MEDIUM_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 901){
          $h_ar_tig = round($h_ar_ti * $HIGH_GAN, PHP_ROUND_HALF_UP);
        }
        $h_ar_tigf = round($h_ar_tig / $EXTERNAL_CURRENCY, PHP_ROUND_HALF_UP);
      }else{
        $h_ar_t = round($g_ar, 2);
        $h_ar_ti = round($h_ar_t, PHP_ROUND_HALF_UP);
        if($h_ar_ti <= 2){
          $h_ar_tig = round(9999.1 * $HIGH_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 2 && $h_ar_ti < 300){
          $h_ar_tig = round($h_ar_ti * $LOW_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 301 && $h_ar_ti < 500){
          $h_ar_tig = round($h_ar_ti * $MEDIUMLOW_GAN, PHP_ROUND_HALF_UP);
        }elseif(number_format($h_ar_ti, 2) > 501 && round(number_format($h_ar_ti, 2)) < 900){
          $h_ar_tig = round($h_ar_ti * $MEDIUM_GAN, PHP_ROUND_HALF_UP);
        }elseif($h_ar_ti > 901){
          $h_ar_tig = round($h_ar_ti * $HIGH_GAN, PHP_ROUND_HALF_UP);
        }
        $h_ar_tigf = round($h_ar_tig / $EXTERNAL_CURRENCY, PHP_ROUND_HALF_UP);
      }

      $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference = "'.$a_ar.'"');
      $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
      $id_product = $conslt_pe['id_product'];
      #$price = $db->query('UPDATE ps_product_shop SET price = "'.$h_ar_tigf.'" WHERE id_product = "'.$conslt_pe['id_product'].'"');

      /*$stock_get_a = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$conslt_pe['id_product'].'"');
      $stock_get_a = $stock_get_a->fetch_array(MYSQLI_ASSOC);*/
      $stock_get_a = $f_ar;

      #$stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_a.'" WHERE id_product = "'.$conslt_pe['id_product'].'"');
    }
  }
}
$a= new listsUpdate;
$a->arroba_update();
