<?php
require('../vendor/autoload.php');
include('../auth.php');
$a = new auther();
?>

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
      ¡Ah ocurrido un erro con tu correo!
    </div>
    <div class="ui right aligned content">
      <p class="erroreinv">No coincide con alguna cuenta en nuestro sistema, porfavor intenta con otro correo</p>
    </div>
    <div class="center aligned actions">
      <div class="ui green ok inverted button">
        <i class="checkmark icon"></i>
        Yes
      </div>
    </div>
  </div>
    <div class="no example">
      <h4 class="ui header">Forcing a Choice</h4>
      <p>You can disable a modal's dimmer from being closed by click to force a user to make a choice</p>
      <div class="code" data-demo="true">
      $('.basic.test.modal').modal('setting', 'closable', true).modal('show');
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

<form method="GET" action="/auth/test.php">
  <input name="error" type="text" />
  <input type="submit" />
</form>

</body>
</html>
