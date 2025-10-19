<?php

    class Usuario
    {
        const TABELA = 'usuario';
        var $id = 0;
        var $nome = '';
        var $email = '';
        var $criado = '';
        var $editado = '';

        function __construct()
        {
        }

        public function salvar(): bool
        {
            if ($this->id == 0) {
                $this->id = inserir($this);
                return $this->id != 0;
            } else {
                return true;
            }
        }

        public static function carregar(int $id)
        {
            return carregar($this->id, self::TABELA);
        }
    }