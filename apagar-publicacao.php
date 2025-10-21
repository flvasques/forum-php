<?php
    include_once './config.php';
    session_start();

    if (empty($_SESSION['usr'])) {
        header('location:index.php');
    }

    if(!empty($_GET['topico'])) {
        $id = intval($_GET['topico']);
        $topico = Topico::carregar(id: $id);
        logErro('carregou');
        if (empty($topico) ||
            (!empty($topico) && $topico->usuario_id != $_SESSION['usr']->id)
        ) {
            LogErro($topico->usuario_id);
        } else {
            $topico->apagarComentarios();
            $topico->apagar();
            header('location:meus-dados.php');
        }
    }

