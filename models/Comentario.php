<?php
    class Comentario extends BaseModel
    {
        const TABELA = 'comentarios';
        public $id = 0;
        public $usuario_id = 0;
        public $topico_id = 0;
        public $texto = '';
        public $criado = '';
        public $editado = '';

        public function getUsuario(): ?Usuario
        {
            return Usuario::carregar($this->usuario_id);
        }

        public function getTopico(): ?Topico
        {
            return Topico::carregar($this->topico_id);
        }

    }
?>