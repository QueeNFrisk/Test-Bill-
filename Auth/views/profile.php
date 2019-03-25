<?php

?>

<html>
  <head>
    <script src="https://semantic-ui.com/javascript/library/jquery.min.js"></script>
    <script src="https://semantic-ui.com/javascript/library/highlight.min.js"></script>
    <script src="https://semantic-ui.com/javascript/library/history.min.js"></script>
    <script src="https://semantic-ui.com/dist/semantic.min.js"></script>
    <script src="./docs.js"></script>
    <link rel="stylesheet" type="text/css" class="ui" href="https://semantic-ui.com/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://semantic-ui.com/stylesheets/docs.css">
    <link rel="stylesheet" type="text/css" href="../../assets/profile.css">
    <script type="text/javascript" src="https://cdn.transifex.com/live.js"></script>
  </head>
  <body onload="$('.visible.example .ui.sidebar').sidebar({context: '.visible.example .bottom.segment'}).sidebar('toggle');">
    <div id="menu">
      <div class="ui bottom attached segment pushable">
        <div class="ui visible inverted left vertical sidebar menu">
          <a class="item">
            <i class="home icon"></i>
            Inicio
          </a>
          <a class="item">
            <i class="user layout icon"></i>
            Perfil
          </a>
          <a class="item">
            <i class="address book outline icon"></i>
            Contactos
          </a>
          <a class="item">
            <i class="slack hash icon"></i>
            Slack
          </a>
          <a class="item">
            <i class="clipboard outline icon"></i>
            Listas
          </a>
          <a class="item">
            <i class="dollar sign icon"></i>
            Cotizaciones
          </a>
          <a class="item">
            <i class="exclamation triangle icon"></i>
            Alertas
          </a>
          <a class="item">
            <i class="calendar alternate outline icon"></i>
            Planeacion
          </a>
          <a class="item">
            <i class="google drive icon"></i>
            Drive
          </a>
          <a class="item">
            <i class="gitlab icon"></i>
            Git
          </a>
        </div>
      </div>
    </div>
  </body>
</html>
