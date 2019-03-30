<?php

include('insertUpdate.php');
$a = new listsUpdate;


$arroba = md5('arroba');
$fastek = md5('fastek');
$ideac = md5('ideac');
$importacion = md5('importacion');
$techsmart = md5('techsmart');
if(isset($_GET['q']) == $arroba){
  $a->arroba_update();

}elseif(isset($_GET['q']) == $fastek){
  $a->fastek_update();

}elseif(isset($_GET['q']) == $ideac){
  $a->ideac_update();

}elseif(isset($_GET['q']) == $importacion){
  $a->importacion_update();

}elseif(isset($_GET['q']) == $techsmart){
  $a->techsmart_update();
}

?>

<html>
  <head>
    <title>Bill</title>
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet" />
    <link rel="stylesheet" href="node_modules/nes.css/css/nes.css" />
    <link rel="stylesheet" href="assets/default.ness.css" />
  </head>
  <body>
    <div class="nes">
      <div class="logox">
        <i class="nes-ash"></i>
      </div>
      <div class="kindred nes-container with-title is-centered is-top">
        <p class="title">Bill</p>
        <section class="topic">
          <p><a href="">#</a> Actualizar:</p>
        </section>
        <section>
          <div class="kin is-custom-ar nes-container with-title is-centered">
            <p class="title">Arroba</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/arroba.png">
            <form method="POST" action="<?php echo "?q=".md5('arroba'); ?>"><button type="submit" class="nes-btn is-primary">Subir</button></form>
          </div>
          <div class="kin is-custom-fa nes-container with-title is-centered">
            <p class="title">Fastek</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/fastek.png">
            <form method="POST" action="<?php echo "?q=".md5('fastek'); ?>"><button type="submit" class="nes-btn is-primary">Subir</button></form>
          </div>
          <div class="kin is-custom-id nes-container with-title is-centered">
            <p class="title">IDEAC</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/ideac_pixel.png">
            <form method="POST" action="<?php echo "?q=".md5('ideac'); ?>"><button type="submit" class="nes-btn is-primary">Subir</button></form>
          </div>
          <div class="kin is-custom-im nes-container with-title is-centered">
            <p class="title">Importacion</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/importacion_pixel.png">
            <form method="POST" action="<?php echo "?q=".md5('importacion'); ?>"><button type="submit" class="nes-btn is-primary">Subir</button></form>
          </div>
          <div class="kin is-custom-te nes-container with-title is-centered">
            <p class="title">Techsmart</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/techsmart.png">
            <form method="POST" action="<?php echo "?q=".md5('techsmart'); ?>"><button type="submit" class="nes-btn is-primary">Subir</button></form>
          </div>
          <div class="kin is-custom-cv nes-container with-title is-centered">
            <p class="title">CVA</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/CVA.jpg">
            <button type="button" class="nes-btn is-primary">Subir</button>
          </div>
          <div class="kin is-custom-pc nes-container with-title is-centered">
            <p class="title">PCH</p>
            <img class="nes-avatar is-large"style="image-rendering: pixelated;" src="assets/providers/pch.png">
            <button type="button" class="nes-btn is-primary">Subir</button>
          </div>
        </section>
      </div>
      <div class="kin-nes-progrss-bar">
        <progress class="nes-progress is-primary" value="<?php var_export($i); ?>" max="2605"></progress>
      </div>
    </div>
  </body>
</html>
