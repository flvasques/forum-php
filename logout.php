<?php

    include_once './config.php';
    session_start();

    if(!empty($_SESSION['usr'])) {
        session_destroy();
    }

    header('location:index.php');