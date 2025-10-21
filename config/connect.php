<?php


function connectarBanco() {
    try {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $base = "forum";
        $conn = mysqli_connect($host, $user, $pass, $base);

        if(mysqli_connect_error()) {
            $e = "Falha no conexão no servidor: " . $host . ": ". mysqli_error() . "\n";
            logErro($e);
            $conn = null;
        }
        return $conn;
    } catch (\Throwable $th) {
        logErro($th);
    }
    
}

function desconnectarBanco($conn) {
    mysqli_close($conn);
}

