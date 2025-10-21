<?php
    include_once './config.php';
    session_start();
    include_once './src/head.php';

    if (empty($_SESSION['usr'])) {
        header('location:index.php');
    }

    if(!empty($_GET['topico'])) {
        $id = intval($_GET['topico']);
        $topico = Topico::carregar($id);
        if (empty($topico) ||
            (!empty($topico) && $topico->usuario_id != $_SESSION['usr']->id)
        ) {
            header('location:index.php');
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($topico)) {
            $topico = new Topico();
        }
        $topico->usuario_id = $_SESSION['usr']->id;
        $topico->titulo = htmlspecialchars($_POST['titulo']);
        $topico->texto = htmlspecialchars($_POST['texto']);
        if ($topico->salvar()) {
            header('location:topicos.php?topico=' . $topico->id);
        } else {
            $error = "Falha ao criar tópico.";
        }
    }

?>
    <section class="container">
        <h5>Nova Publicação </h5>

        <div class="row">
            <div class="col s12 m10 card card-panel">
                <form action="publicacao.php?topico=<?php echo $topico->id; ?>" method="POST">
                    <div class="card-content">
                        <div class="input-field col s12">
                            <input id="input_text" type="text" name="titulo" data-length="255"
                            class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                            value = "<?php echo $topico->titulo ?? ''; ?>" required />
                            <label for="input_text">Título</label>
                        </div>

                        <div class="input-field col s12">
                            <textarea id="textarea1" name="texto" class="materialize-textarea" data-length="1000"
                            class="validate <?php if (!empty($error)) { echo 'invalid'; } ?>"
                            required><?php echo $topico->texto ?? ''; ?></textarea>
                            <label for="textarea1">Texto</label>
                        </div>
                        <div class="row col s12">
                            <?php
                                if (!empty($error)) {
                                    echo '<h5 class="center-align red-text">' . $error . '</h5>';
                                }
                            ?>
                        </div>
                        <div class="row">
                            <div class="col s2 offset-s10">
                                <button class="btn waves-effect waves-light green accent-4" type="submit" name="action">
                                    Salvar
                                    <i class="material-icons right">create</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php
    include_once './src/footer.php';
?>
<script>
    $(document).ready(function() {
        $('textarea#textarea1').characterCounter();
    });
</script>