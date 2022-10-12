<?php
session_start();
// verification si la personn est bien passé par la page pour se connecter
?>
<!DOCTYPE html>


<!-- new login -->
<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
    <style>
    body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
    }

    body {
        background: #fff;
    }

    .input-field input[type=date]:focus+label,
    .input-field input[type=text]:focus+label,
    .input-field input[type=email]:focus+label,
    .input-field input[type=password]:focus+label {
        color: #e91e63;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=email]:focus,
    .input-field input[type=password]:focus {
        border-bottom: 2px solid #e91e63;
        box-shadow: none;
    }
    </style>
</head>

<body>
    <div class="section"></div>
    <main>

        <center>
            <img class="responsive-img" style="width: 250px;" src="plugins/k2-pdf.jpg" />
            <div class="section"></div>

            <h5 class="black-text">Veuillez vous connecter à votre compte</h5>
            <div class="section"></div>
            <?php
      if (@$_GET['Empty'] == true) {
      ?>
            <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Empty'] ?></div>
            <?php
      }
      ?>


            <?php
      if (@$_GET['Invalid'] == true) {

      ?>
            <div class="alert-light text-danger text-center py-3"><?php echo $_GET['Invalid'] ?></div>
            <?php
      }
      ?>
            <div class="container">
                <div class="z-depth-1 grey lighten-4 row"
                    style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

                    <form class="col s12" action="process.php" method="post">
                        <div class='row'>
                            <div class='col s12'>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12'>
                                <input class='validate' type="text" placeholder="Login" name="login" />
                                <label for='email'>
                                    Entrer votre Login</label>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='input-field col s12'>
                                <input class='validate' type='password' name="password" id='password' />
                                <label for='password'>
                                    Entrer votre mot de passe</label>
                            </div>
                        </div>

                        <br />
                        <center>
                            <div class='row'>
                                <button type='submit' name="Login"
                                    class='col s12 btn btn-large waves-effect  blue-grey darken-4 btn btn-success'>Connexion</button>
                            </div>
                        </center>
                    </form>
                </div>
            </div>
        </center>

        <div class="section"></div>
        <div class="section"></div>
    </main>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>