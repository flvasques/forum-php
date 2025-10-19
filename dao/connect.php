<?php


function connectarBanco() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $base = "forum";
    $conn = mysqli_connect($host, $user, $pass, $base);

    if(mysqli_error()) {
        echo "Falha no conexão no servidor: " . $host . ":".mysqli_error() . "\n";
        log_erro($e);
        $conn = null;
    }
    return $conn;
}

function iniciarTransacao($conn) {
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);
    mysqli_autocommit($conn, FALSE);
    return $conn;
}

function commit($conn) {
    mysqli_commit($conn);
}

function rollBack($conn) {
    mysqli_rollback($conn);
}

function desconnectarBanco($conn) {
    mysqli_close($conn);
}

