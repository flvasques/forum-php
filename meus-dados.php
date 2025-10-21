<?php
    include_once './config.php';
    session_start();
    include_once './src/head.php';

    if (empty($_SESSION['usr'])) {
        header('location:index.php');
    }
    $filtro = "WHERE usuario_id = " . $_SESSION['usr']->id;
    $topicos = Topico::listar(filtro: $filtro);
?>

    <section class="container">
        <div class="row">
            <div class="col s12 card card-panel">
                <div class="card-content">
                    <strong class="card-title">
                        Meus Dados
                    </strong>
                    <p><?php echo $_SESSION['usr']->nome; ?></p>
                    <p><?php echo $_SESSION['usr']->email; ?></p>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 card card-panel">
                <div class="card-content">
                    <strong class="card-title">
                       Minhas publicações
                    </strong>
                    <table class="col s12 striped">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Texto</th>
                            <th scope="col">Ações</th>
                        </thead>
                        <tbody>
                            <?php if (count($topicos) == 0) { ?>
                                <tr>
                                    <td colspan="4">Sem Publicações</td>
                            <?php } ?>
                            <?php foreach ($topicos as $key => $topico) { ?>
                                <tr>
                                    <td><?php echo $topico->id; ?></td>
                                    <td><?php echo substr($topico->titulo, 0, 100); ?></td>
                                    <td><?php echo substr($topico->texto, 0, 150); ?>...</td>
                                    <td style="width:120px">
                                        <a href="topicos.php?topico=<?php echo $topico->id; ?>" title="ler publicação e comentarios"
                                            class="btn waves-effect waves-light blue darken-3" name="action">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                        <a href="publicacao.php?topico=<?php echo $topico->id; ?>" title="editar"
                                            class="btn waves-effect waves-light green accent-4" name="action">
                                            <i class="material-icons">description</i>
                                        </a>
                                        <a href="apagar-publicacao.php?topico=<?php echo $topico->id; ?>" title="apagar"
                                            class="btn waves-effect waves-light red" name="action">
                                            <i class="material-icons">delete_forever</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>


<?php
    include_once './src/footer.php';
?>