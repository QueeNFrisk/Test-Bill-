<?php
require('../../vendor/autoload.php');
include('../auth.php');
?>

<html>
<script src="https://semantic-ui.com/javascript/library/jquery.min.js"></script>
<script src="https://semantic-ui.com/javascript/library/highlight.min.js"></script>
<script src="https://semantic-ui.com/javascript/library/history.min.js"></script>
<script src="https://semantic-ui.com/dist/semantic.min.js"></script>
<script src="./docs.js"></script>
<link rel="stylesheet" type="text/css" class="ui" href="https://semantic-ui.com/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://semantic-ui.com/stylesheets/docs.css">
<link rel="stylesheet" type="text/css" href="../assets/default.css">
<script type="text/javascript" src="https://cdn.transifex.com/live.js"></script>

<body id="example" class="modal-page" onload="<?php $a->__load(); ?>">
<div class="main center aligned ui container">
  <div class="ui center aligned small basic test modal">
    <div class="ui center aligned icon header">
      <i class="massive red times icon "></i>
      ¡Lo haz intentado demasiadas veces!
    </div>
    <div class="ui right aligned content">
      <p class="erroreinv">Contactate con el provedor de este servicio pra pueda reestablecer tu contraseña</p>
    </div>
    <div class="center aligned actions">
      <div class="ui blue ok inverted button">
        <i class="checkmark icon"></i>
        Ok...
      </div>
    </div>
  </div>
<script>
  window.less = {
    async        : true,
    environment  : 'production',
    fileAsync    : false,
    onReady      : true,
    useFileCache : true
  };
</script>
<script src="https://semantic-ui.com/javascript/library/less.min.js"></script>

</body>
</html>
