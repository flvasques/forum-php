<?php
    include_once './config.php';
    session_start();

    if(!empty($_SESSION['usr'])) {
        header('location:index.php');
    }

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = new Usuario();
        $usuario->nome = htmlspecialchars($_POST['nome']);
        $usuario->email = htmlspecialchars($_POST['email']);
        if ($usuario->salvar()) {
            $_SESSION['usr'] = $usuario;
           header('location:meus-dados.php');
        } else {
            $error = "Falha ao Realizar cadatro.";
        }
    }

    include_once './src/head.php';
?>

    <section class="container">

        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <h5 class="card-title">Cadastrar</h5>
                    <div class="row">
                        <form action="cadastrar.php" method="POST">
                            <div class="input-field col s6 offset-s3">
                                <input id="nome" name="nome" type="text" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                value = "<?php echo $_POST['nome'] ?? ''; ?>"
                                required />
                                <label for="nome">Nome Completo</label>
                            </div>
                            <div class="input-field col s6 offset-s3">
                                <input id="email" name="email" type="email" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                value = "<?php echo $_POST['email'] ?? ''; ?>"
                                required />
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field col s6 offset-s3">
                                <input id="password" name="password" type="password" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                    value = "<?php echo $_POST['password'] ?? ''; ?>"
                                    required />
                                <label for="password">Senha</label>
                            </div>
                            <div class="input-field col s6 offset-s3">
                                <input id="repeat_password" name="repeat_password" type="password" class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                                    value = "<?php echo $_POST['repeat_password'] ?? ''; ?>"
                                    required />
                                <label for="repeat_password">Repita Senha</label>
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
                                        Cadastrar
                                        <i class="material-icons right">done</i>
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

  
        
<?php
    include_once './src/footer.php';
?>