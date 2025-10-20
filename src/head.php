<!DOCTYPE html>
<html  lang="pt-br">
    <head>
        <title>Forum - PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </head>
    <body >
        <nav>
            <div class="nav-wrapper teal lighten-2">
                <a href="#" class="brand-logo">Forum - PHP</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php
                        if (empty($_SESSION['usr'])) {
                            echo '<li><a href="login.php">Login</a></li>';
                            echo '<li><a href="sass.html">Cadastrar</a></li>';
                        } else {
                            echo '<li><a href="sass.html">' . $_SESSION['usr']->nome . '</a></li>';
                            echo '<li><a href="logout.php">Logout</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </nav>