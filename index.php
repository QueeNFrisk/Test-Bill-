<?php

include('vendor/autoload.php');
include('latch.php');


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bill | login</title>
    <link rel="stylesheet" type="text/css" href="assets/default.css" />
    <script src="https://semantic-ui.com/javascript/library/jquery.min.js"></script>
    <script src="https://semantic-ui.com/javascript/library/highlight.min.js"></script>
    <script src="https://semantic-ui.com/javascript/library/history.min.js"></script>
    <script src="https://semantic-ui.com/dist/semantic.min.js"></script>
    <script src="https://semantic-ui.com/javascript/docs.js"></script>
    <link rel="stylesheet" type="text/css" class="ui" href="https://semantic-ui.com/dist/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="https://semantic-ui.com/stylesheets/docs.css">
    <script type="text/javascript" src="https://cdn.transifex.com/live.js"></script>
  </head>
  <body>
    <div class="ui center aligned container" id="container">
      <img src="assets/hp.png" width="500" height="150" id="logo">
      <div class="ui placeholder segment">
        <div class="ui two column stackable center aligned grid">
          <div class="ui vertical divider">Ó</div>
          <div class="middle aligned row">
            <div class="column">
              <div class="ui icon header" style="margin-bottom:6%"><i class="keyboard icon"></i>Email and Password </div>
                <div class="field">
                  <form method="POST" action="">
                  <div class="ui user">
                    <div class="ui icon input">
                      <input class="prompt_username" name="email" type="text" placeholder="Email" style="margin-bottom:5%">
                      <i class="large user circle outline icon" style="margin-top:-5px"></i>
                    </div>
                  </div>
                  <div class="ui user">
                    <div class="ui icon input">
                      <input class="prompt_password" name="password" type="password" placeholder="Password" style="margin-bottom:5%">
                      <i class="large unlock alternate icon" style="margin-top:-5px"></i>
                    </div>
                  </div>
                  <button class="fluid ui labeled icon button" style="margin-bottom:7%"><i class="sign-in icon"></i> Entrar </button>
                </div>
              </form>
            </div>
            <div class="column">
              <div class="ui icon header" style="margin-bottom:6%"><i class="large key icon"></i> Token </div>
              <div class="ui user">
                <div class="ui icon input">
                  <input class="prompt_token" type="text" placeholder="Email..." style="margin-bottom:5%">
                  <i class="large shield alternate icon " style="margin-top:-5px"></i>
                </div>
              </div>
              <button class="fluid ui labeled icon button"><i class="sign-in icon"></i> Entrar </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>

<?php

include('Auth/auth.php');
