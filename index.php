<?php
    include_once './config.php';
    $u = new Usuario();
    $u->nome = 'Juca';
    $u->email = 'juca@juca.com';
    var_dump($u);
    echo '<br>==================';
    $u->salvar();
    var_dump($u);

?>
