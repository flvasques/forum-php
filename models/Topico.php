<?php

    class Topico extends BaseModel
    {
        const TABELA = 'topicos';
        public $id = 0;
        public $usuario_id = 0;
        public $titulo = '';
        public $texto = '';
        public $criado = '';
        public $editado = '';


        public function getUsuario(): ?Usuario
        {
            return Usuario::carregar(id: $this->usuario_id);
        }

        public function getComentarios(): array
        {
            return Comentario::listar(filtro: "WHERE topico_id = $this->id");
        }

        public function apagarComentarios()
        {
            $tabela = Comentario::TABELA;
            $query = "DELETE FROM $tabela WHERE id = $this->id";
            $this->executar($query);
        }

    }