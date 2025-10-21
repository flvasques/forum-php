<?php
    include_once './config.php';
    session_start();
    include_once './src/head.php';
    if(!empty($_GET['topico'])) {
        $id = intval($_GET['topico']);
        $topico = Topico::carregar($id);
        if (empty($topico)) {
            header('location:index.php');
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION['usr'])) {
           $comentario = new Comentario();
           $comentario->usuario_id = $_SESSION['usr']->id;
           $comentario->topico_id = $topico->id;
           $comentario->texto = htmlspecialchars($_POST['comentario']);
           $comentario->salvar();
        }

       $comentarios = $topico->getComentarios();
    } else {
        header('location:index.php');
    }
?>
    <section class="container">
        <div class="row">
            <div class="col s12 m10 card card-panel">
                <div class="card-content">
                    <strong class="card-title"><?php echo $topico->titulo; ?></strong>
                    <pre class="" style="white-space: pre-wrap;"><?php echo $topico->texto; ?></pre>
                    <p class="right-align">
                        <small>Por: <?php echo $topico->getUsuario()->getPrimeiroNome(); ?></small>
                    </p>
                </div>
            </div>
        </div>
        <?php if( !empty($_SESSION['usr']) && ($_SESSION['usr']->id != $topico->usuario_id) ) { ?>
            <div class="row">
                <div class="col s12 m10 card card-panel">
                    <form action="topicos.php?topico=<?php echo $topico->id; ?>" method="POST">
                        <div class="card-content">
                            <div class="input-field col s12">
                                <textarea id="textarea1" name="comentario" class="materialize-textarea" data-length="1000" required></textarea>
                                <label for="textarea1">Enviar Comentario</label>
                            </div>
                            <div class="row">
                                <div class="col s2 offset-s10">
                                    <button class="btn waves-effect waves-light" type="submit" name="action">
                                        Enviar
                                        <i class="material-icons right">chat_bubble</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
        <h5>Comentarios </h5>
        <p>Total: <?php echo count($comentarios); ?>
        <?php foreach ($comentarios as $key => $comentario) { ?>
            <div class="row">
                <div class="col s12 m10 card card-panel">
                    <div class="card-content">
                        <pre class="" style="white-space: pre-wrap;"><?php echo $comentario->texto; ?></pre>
                        <p class="right-align">
                            <small>Por: <?php echo $comentario->getUsuario()->getPrimeiroNome(); ?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </section>

<?php
    include_once './src/footer.php';
?>
<script>
    $(document).ready(function() {
        $('textarea#textarea1').characterCounter();
    });
</script>
