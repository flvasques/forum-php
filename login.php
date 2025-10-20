<?php
    include_once './config.php';
    session_start();

    if(!empty($_SESSION['usr'])) {
        header('location:index.php');
    }

    if(!empty($_POST['email']) && !empty($_POST['password'])) {
        $usuario = new Usuario();
        if ($usuario->login($_POST['email'], $_POST['password'])) {
            $_SESSION['usr'] = $usuario;
            header('location:index.php');
        } else {
            $error = "Usuário ou senha incorretos.";
        }
    }

    include_once './src/head.php';
?>

    <div class="container">

        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <form action="login.php" method="POST">
                            <div class="input-field col s6 offset-s3">
                                <input id="email" name="email" type="email" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                value = "<?php echo $_POST['email'] ?? ''; ?>"
                                required />
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field col s6 offset-s3">
                                <input id="password" name="password" type="password" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                    value = ""
                                    required />
                                <label for="password">Password</label>
                            </div>
                            <div class="row col s12">
                                <?php
                                    if (!empty($error)) {
                                        echo '<h5 class="center-align red-text">' . $error . '</h5>';
                                    }

                                ?>
                            </div>
                            <div class="row">
                                <div class="col s2 offset-s8">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Login
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
        
    </body>
</html>