<?php

//error_reporting(1);

require 'vendor/autoload.php';

//include 'latch.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

set_time_limit(500);

function arroba_update(){
  $TAXE_DEFAULT = round('1.16',2);
  $INTERAL_CURRENCY = round('19.40', 2);
  $EXTERNAL_CURRENCY = round('19.70', 2);
  $HIGH_GAN = round('1.1', 2);
  $MEDIUM_GAN = round('1.20', 2);
  $MEDIUMLOW_GAN = round('1.30', 2);
  $LOW_GAN = round('1.5', 2);

  $db = new mysqli('192.168.50.36', 'Daniel', '', 'prestashop');

  $arroba = __DIR__ . '/Lists/Arroba.xlsx';
  // __ARROBA IMPORT TO JSON -> EXPORT TO MYSQL
  $arroba_sheet = IOFactory::load($arroba);
  $arroba_sheet = $arroba_sheet->getActiveSheet()->toArray(null, true, true, true);
  for($i = 1; $i <= count($arroba_sheet); $i++){

    $a_ar = str_replace('"', " ", str_replace("/", " ", $arroba_sheet[$i]["A"]));
    $b_ar = $arroba_sheet[$i]["B"];
    $c_ar = $arroba_sheet[$i]["C"];
    $d_ar = $arroba_sheet[$i]["D"];
    $e_ar = $arroba_sheet[$i]["E"];
    $f_ar = $arroba_sheet[$i]["F"];
    $g_ar = $arroba_sheet[$i]["G"];

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
    $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference = "'.$a_ar.'"');
    $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
    $id_product = $conslt_pe['id_product'];
    $price = $db->query('UPDATE ps_product_shop SET price = "'.$h_ar_tigf.'" WHERE id_product = "'.$i.'"');
    $stock_get_a = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$i.'"');
    $stock_get_a = $stock_get_a->fetch_array(MYSQLI_ASSOC);
    $stock_get_a = $f_ar;
    $stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_a.'" WHERE id_product = "'.$i.'"');
    var_dump($stock_put);
  }
}


function fastek_update(){
  $TAXE_DEFAULT = round('1.16',2);
  $INTERAL_CURRENCY = round('19.40', 2);
  $EXTERNAL_CURRENCY = round('19.70', 2);
  $HIGH_GAN = round('1.1', 2);
  $MEDIUM_GAN = round('1.20', 2);
  $MEDIUMLOW_GAN = round('1.30', 2);
  $LOW_GAN = round('1.5', 2);

  $db = new mysqli('192.168.50.36', 'Daniel', '', 'prestashop');

  $fastek = __DIR__ . '/Lists/Fastek.xlsx';
  // __FASTEK IMPORT TO JSON -> EXPORT TO MYSQL
  $fastek_sheet = IOFACTORY::load($fastek);
  $fastek_sheet = $fastek_sheet->getActiveSheet()->toArray(null, true, true, true);
  for($i = 1; $i <= count($fastek_sheet); $i++){
    $a_fa = str_replace('"', " ", str_replace("/", " ", $fastek_sheet[$i]["A"])); // Referencia
    $b_fa = str_replace('"', " ", str_replace("/", " ", $fastek_sheet[$i]["B"])); // Nombre
    $c_fa = $fastek_sheet[$i]["C"]; // Precio Original + IVA
    $d_fa = round($fastek_sheet[$i]["D"]); // GDL
    $c_fa = round($c_fa);
    $e_fa_ti = $c_fa * $INTERAL_CURRENCY;
    if($e_fa_ti <= 2){
      $e_fa_tig = 9999.1 * $HIGH_GAN;
    }elseif($e_fa_ti > 2 && $e_fa_ti < 300){
      $e_fa_tig = $e_fa_ti * $LOW_GAN;
    }elseif($e_fa_ti > 301 && $e_fa_ti < 500){
      $e_fa_tig = $e_fa_ti * $MEDIUMLOW_GAN;
    }elseif($e_fa_ti > 501 && $e_fa_ti < 900){
      $e_fa_tig = $e_fa_ti * $MEDIUM_GAN;
    }elseif($e_fa_ti > 901){
      $e_fa_tig = $e_fa_ti * $HIGH_GAN;
    }
    $e_fa_tigf = $e_fa_tig / $EXTERNAL_CURRENCY;
    $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference ="'.$a_fa.'"');
    $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
    $price = $db->query('UPDATE ps_product_shop SET price = "'.$e_fa_tigf.'" WHERE id_product = "'.$i.'"');
    $stock_get_b = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$i.'"');
    $stock_get_b = $stock_get_b->fetch_array(MYSQLI_ASSOC);
    $stock_get_b = number_format($stock_get_b['quantity'] + $d_fa, 0);
    $stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_b.'" WHERE id_product = "'.$i.'"');
  }
}


function ideac_update(){
  $TAXE_DEFAULT = round('1.16',2);
  $INTERAL_CURRENCY = round('19.40', 2);
  $EXTERNAL_CURRENCY = round('19.70', 2);
  $HIGH_GAN = round('1.1', 2);
  $MEDIUM_GAN = round('1.20', 2);
  $MEDIUMLOW_GAN = round('1.30', 2);
  $LOW_GAN = round('1.5', 2);

  $db = new mysqli('192.168.50.36', 'Daniel', '', 'prestashop');

  $ideac = __DIR__ . '/Lists/Ideac.xlsx';
  // __IDEAC IMPORT TO JSON -> EXPORT TO MYSQL
  $ideac_sheet = IOFACTORY::load($ideac);
  $ideac_sheet = $ideac_sheet->getActiveSheet()->toArray(null, true, true, true);
  for($i = 1; $i <= count($ideac_sheet); $i++){
    $a_id = str_replace('"', " ", str_replace("/", " ", $ideac_sheet[$i]["A"])); // Referencia
    $b_id = str_replace('"', " ", str_replace("/", " ", $ideac_sheet[$i]["B"])); // Nombre de producto
    $c_id = str_replace('"', " ", str_replace("/", " ", $ideac_sheet[$i]["C"])); // Precio Original
    $d_id = str_replace('"', " ", str_replace("/", " ", $ideac_sheet[$i]["D"])); // Moneda
    $f_id = str_replace('"', " ", str_replace("/", " ", $ideac_sheet[$i]["F"])); // Total de productos
    $c_id = round($c_id, PHP_ROUND_HALF_UP);
    $g_id_ti = round($c_id * $INTERAL_CURRENCY, PHP_ROUND_HALF_UP);
    if($g_id_ti <= 2){
      $g_id_tig = 9999.1 * $HIGH_GAN;
    }elseif($g_id_ti > 2 && $g_id_ti < 300){
      $g_id_tig = $g_id_ti * $LOW_GAN;
    }elseif($g_id_ti > 301 && $g_id_ti < 500){
      $g_id_tig = $g_id_ti * $MEDIUMLOW_GAN;
    }elseif($g_id_ti > 501 && $g_id_ti < 900){
      $g_id_tig = $g_id_ti * $MEDIUM_GAN;
    }elseif($g_id_ti > 901){
      $g_id_tig = $g_id_ti * $HIGH_GAN;
    }
    $g_id_tigf = $g_id_tig / $EXTERNAL_CURRENCY;
    $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference ="'.$a_id.'"');
    $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
    $price = $db->query('UPDATE ps_product_shop SET price = "'.$g_id_tigf.'" WHERE id_product = "'.$i.'"');
    $stock_get_c = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$i.'"');
    $stock_get_c = $stock_get_c->fetch_array(MYSQLI_ASSOC);
    $stock_get_c = number_format($stock_get_c['quantity'], 0) + $f_id;
    $stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_c.'" WHERE id_product = "'.$i.'"');
  }
}

function importacion_update(){
  $TAXE_DEFAULT = round('1.16',2);
  $INTERAL_CURRENCY = round('19.40', 2);
  $EXTERNAL_CURRENCY = round('20.70', 2);
  $HIGH_GAN = round('1.1', 2);
  $MEDIUM_GAN = round('1.20', 2);
  $MEDIUMLOW_GAN = round('1.30', 2);
  $LOW_GAN = round('1.5', 2);

  $db = new mysqli('192.168.50.36', 'Daniel', '', 'prestashop');

  $importacion = __DIR__ . '/Lists/Importacion.xlsx';
  // __IMPORTACION IMPORT TO JSON -> EXPORT TO MYSQL
  $importacion_sheet = IOFACTORY::load($importacion);
  $importacion_sheet = $importacion_sheet->getActiveSheet()->toArray(null, true, true, true);
  for($i = 1; $i <= count($importacion_sheet); $i++){
    $a_im = str_replace('"', " ", str_replace("/", " ", $importacion_sheet[$i]["A"])); // Nombre de producto
    $b_im = str_replace('"', " ", str_replace("/", " ", $importacion_sheet[$i]["B"])); // Referencia
    $c_im = str_replace('"', " ", str_replace("/", " ", $importacion_sheet[$i]["C"])); // GDL
    $d_im = round(str_replace('"', " ", str_replace("/", " ", $importacion_sheet[$i]["D"])), 2); // Precio Original
    $d_im = round($d_im, PHP_ROUND_HALF_UP);
    $e_im_ti = round($d_im * $INTERAL_CURRENCY, PHP_ROUND_HALF_UP);
    if($e_im_ti <= 2){
      $e_im_tig = 9999.1 * $HIGH_GAN;
    }elseif($e_im_ti > 2 && $e_im_ti < 300){
      $e_im_tig = $e_im_ti * $LOW_GAN;
    }elseif($e_im_ti > 301 && $e_im_ti < 500){
      $e_im_tig = $e_im_ti * $MEDIUMLOW_GAN;
    }elseif($e_im_ti > 501 && $e_im_ti < 900){
      $e_im_tig = $e_im_ti * $MEDIUM_GAN;
    }elseif($e_im_ti > 901){
      $e_im_tig = $e_im_ti * $HIGH_GAN;
    }
    $e_im_tigf = $e_im_tig / round($EXTERNAL_CURRENCY, PHP_ROUND_HALF_UP);
    $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference ="'.$b_im.'"');
    $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
    $price = $db->query('UPDATE ps_product_shop SET price = "'.$e_im_tigf.'" WHERE id_product = "'.$i.'"');
    $stock_get_d = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$i.'"');
    $stock_get_d = round($stock_get_d->fetch_array(MYSQLI_ASSOC));
    $stock_get_d = number_format($stock_get_d['quantity'], 0) + $c_im;
    $stock_put_d = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_d.'" WHERE id_product = "'.$i.'"');
  }
}


function techsmart_update(){
  $TAXE_DEFAULT = round('1.16',2);
  $INTERAL_CURRENCY = round('19.40', 2);
  $EXTERNAL_CURRENCY = round('19.70', 2);
  $HIGH_GAN = round('1.1', 2);
  $MEDIUM_GAN = round('1.20', 2);
  $MEDIUMLOW_GAN = round('1.30', 2);
  $LOW_GAN = round('1.5', 2);

  $db = new mysqli('192.168.50.36', 'Daniel', '', 'prestashop');
  $techsmart = simplexml_load_file('lists/techsmart.xml', 'SimpleXMLElement');
  for($i = 1; $i <= count($techsmart->item)-1; $i++){
    $a_te = str_replace(")", " ", str_replace("(", " ", str_replace("*", " ", str_replace('"', " ", str_replace("/", " ", $techsmart->item->$i->codigo_fabricante))))); // Referencia
    $d_te = str_replace(")", " ", str_replace("(", " ", str_replace("*", " ", str_replace('"', " ", str_replace("/", " ", $techsmart->item->$i->moneda))))); // Moneda
    $b_te = str_replace(")", " ", str_replace("(", " ", str_replace("*", " ", str_replace('"', " ", str_replace("/", " ", $techsmart->item->$i->descripcion))))); // Nombre de producto
    $c_te = str_replace(")", " ", str_replace("(", " ", str_replace("*", " ", str_replace('"', " ", str_replace("/", " ", $techsmart->item->$i->precio))))); // PrecioO
    $f_te = str_replace(")", " ", str_replace("(", " ", str_replace("*", " ", str_replace('"', " ", str_replace("/", " ", $techsmart->item->$i->disponible))))); // GDL
    $c_te = round($c_te, 2);
    if($d_te = "Dolares"){
      $e_te_ti = $c_te * $INTERAL_CURRENCY;
      if($e_te_ti <= 2){
        $e_te_tig = 9999.1 * $HIGH_GAN;
      }elseif($e_te_ti > 2 && $e_te_ti < 300){
        $e_te_tig = $e_te_ti * $LOW_GAN;
      }elseif($e_te_ti > 301 && $e_te_ti < 500){
        $e_te_tig = $e_te_ti * $MEDIUMLOW_GAN;
      }elseif($e_te_ti > 501 && $e_te_ti < 900){
        $e_te_tig = $e_te_ti * $MEDIUM_GAN;
      }elseif($e_te_ti > 901){
        $e_te_tig = $e_te_ti * $HIGH_GAN;
      }
    }else{
      if($e_te_ti <= 2){
        $e_te_tig = 9999.1 * $HIGH_GAN;
      }elseif($e_te_ti > 2 && $e_te_ti < 300){
        $e_te_tig = $e_te_ti * $LOW_GAN;
      }elseif($e_te_ti > 301 && $e_te_ti < 500){
        $e_te_tig = $e_te_ti * $MEDIUMLOW_GAN;
      }elseif($e_te_ti > 501 && $e_te_ti < 900){
        $e_te_tig = $e_te_ti * $MEDIUM_GAN;
      }elseif($e_te_ti > 901){
        $e_te_tig = $e_te_ti * $HIGH_GAN;
      }
    }
    $e_te_tigf = $e_te_tig / $EXTERNAL_CURRENCY;
    $conslt_pe = $db->query('SELECT * FROM ps_product WHERE reference = "'.$a_te.'"');
    $conslt_pe = $conslt_pe->fetch_array(MYSQLI_ASSOC);
    $price = $db->query('UPDATE ps_product_shop SET price = "'.$e_te_tigf.'" WHERE id_product = "'.$i.'"');
    $stock_get_e = $db->query('SELECT * FROM ps_stock_available WHERE id_product = "'.$i.'"');
    $stock_get_e = $stock_get_e->fetch_array(MYSQLI_ASSOC);
    $id_product = $conslt_pe['id_product'];
    $stock_get_e = number_format($stock_get_e['quantity'], 0) + $f_te;
    $stock_put = $db->query('UPDATE ps_stock_available SET quantity = "'.$stock_get_e.'" WHERE id_product = "'.$i.'"');
  }
}
