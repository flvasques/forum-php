<?php

    class Topico
    {
        var $id = 0;
        var $usuario_id = 0;
        var $titulo = '';
        var $texto = '';
        var $criado = '';
        var $editado = '';

        function __construct($usuario_id, $texto)
        {
            $this->usuario_id = $usuario_id;
            $this->texto = $texto;
        }
    }