<?php
    include_once './config.php';
    session_start();
    include_once './src/head.php';
    $topicos = Topico::listar();
?>

    <section class="container">
        <?php foreach ($topicos as $key => $topico) { ?>
            <div class="row">
                <div class="col s12 m10 card card-panel hoverable">
                    <div class="card-content">
                        <strong class="card-title"><a href="topicos.php?topico=<?php echo $topico->id; ?>"><?php echo $topico->titulo; ?></a></strong>
                        <p class="truncate"><a href="topicos.php?topico=<?php echo $topico->id; ?>"><?php echo $topico->texto; ?></a></p>
                        <p class="right-align">
                            <small>Por: <?php echo $topico->getUsuario()->getPrimeiroNome(); ?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>

<?php
    include_once './src/footer.php';
?>

