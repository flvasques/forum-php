<?php

    class BaseModel
    {
        public function salvar(): bool
        {
            if ($this->id == 0) {
                $this->id = inserir($this);
                return $this->id != 0;
            } else {
                return editar($this);
            }
        }

        public function apagar(): bool
        {
            return carregar($this->id, static::TABELA);
        }

        public static function carregar(int $id, string $filtro)
        {
            return carregar($id, static::class, static::TABELA, $filtro);
        }

        public static function listar(string $filtro = ''): array
        {
            return listar(static::class, static::TABELA, $filtro);
        }

        public static function buscar(string $filtro = '')
        {
            return buscar(static::class, static::TABELA, $filtro);
        }
    }
