<?php
    class Comentario
    {
        var $id = 0;
        var $usuario_id = 0;
        var $topico_id = 0;
        var $texto = '';
        var $criado = '';
        var $editado = '';

        function __construct($texto, $topico_id)
        {
            $this->texto = $texto;
            $this->topico_id = $topico_id;
        }
    }
?>