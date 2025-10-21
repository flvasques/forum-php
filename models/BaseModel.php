<?php

    abstract class BaseModel
    {
        public function salvar(): bool
        {
            if ($this->id == 0) {
                $this->id = $this->inserir($this);
                return $this->id != 0;
            } else {
                return $this->editar($this);
            }
        }

        public function apagar(): bool
        {
            try {
                $tabela = static::TABELA;
                $query = "DELETE FROM $tabela WHERE id = $this->id";
                logErro($query);
                $conn = connectarBanco();
                mysqli_query($conn, $query);
                $registros = mysqli_affected_rows($conn);

                return $registros == 1;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                return false;
            }
        }

        public static function carregar(int $id, string $classe = null, string $tabela = null)
        {
            $classe = $classe ?? static::class;
            $tabela = $tabela ?? static::TABELA;
            try {
                $query = "SELECT * FROM $tabela WHERE id = $id";
                $obj = new $classe;
                $conn = connectarBanco();
                $result = mysqli_query($conn, $query);
                $registros = mysqli_num_rows($result);
                if ($registros == 1) {
                    $row = mysqli_fetch_assoc($result);
                    foreach ( $obj as $key => $value ) {
                        $obj->{$key} = $row[$key];
                    }
                } else {
                    desconnectarBanco($conn);
                    return null;
                }

                desconnectarBanco($conn);
                return $obj;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return null;
            }
        }

        public static function listar(string $classe = null, string $tabela = null, string $filtro = '', int $limite = 10): array
        {
            $classe = $classe ?? static::class;
            $tabela = $tabela ?? static::TABELA;
            $lista = [];
            try {
                $pagina = $pagina * $limite;
                $query = "SELECT * FROM $tabela $filtro LIMIT $pagina, $limite";
                $conn = connectarBanco();
                $result = mysqli_query($conn, $query);
                while ($linha = mysqli_fetch_array($result)) {
                    $obj = new $classe;
                    foreach ( $obj as $key => $value ) {
                        $obj->{$key} = $linha[$key];
                    }
                    $lista[] = $obj;
                }
                

                desconnectarBanco($conn);

                return $lista;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return $lista;
            }
        }

        public static function buscar(string $filtro, string $classe = null, string $tabela = null)
        {
            $classe = $classe ?? static::class;
            $tabela = $tabela ?? static::TABELA;
            try {
                $query = "SELECT * FROM $tabela WHERE $filtro";
                $conn = connectarBanco();
                $result = mysqli_query($conn, $query);
                $registros = mysqli_num_rows($result);
                if ($registros == 1) {
                    $obj = new $classe;
                    $row = mysqli_fetch_assoc($result);
                    foreach ( $obj as $key => $value ) {
                        $obj->{$key} = $row[$key];
                    }
                    return $obj;
                } else {
                    desconnectarBanco($conn);
                    return null;
                }

                desconnectarBanco($conn);
                
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return null;
            }

        }

        public function executar(string $query): bool
        {
            try {
                $conn = connectarBanco();
                mysqli_query($conn, $query);
                desconnectarBanco($conn);
                return true;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return false;
            }
        }

        private function inserir($obj): int
        {
            try {
                $query = 'INSERT INTO ' . $obj::TABELA . ' (';
                $colunas = '';
                $valores = '';
                foreach ( $obj as $key => $value ) {
                    if ($key != 'id' &&
                        $key != 'editado' &&
                        $key != 'criado') {
                        $colunas .= $key . ', ';
                        if (is_numeric($value)) {
                            $valores .= $value . ', ';
                        } else {
                            $valores .= "'" .  $value . "', ";
                        }
                    } elseif ($key == 'criado') {
                        $colunas .= $key;
                        $valores .= "'" . date('Y-m-d H:i:s') . "'";
                    }
                }
                $query = $query . $colunas . ') VALUES (' . $valores . ')';
                $conn = connectarBanco();
                mysqli_query($conn, $query);
                $obj->id = mysqli_insert_id($conn);

                desconnectarBanco($conn);
                
                return $obj->id;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return 0;
            }

            
        }

        private function editar($obj): bool
        {
            try {
                $query = 'UPDATE ' . $obj::TABELA . ' SET ';
                $where = 'WHERE id = ';
                foreach ( $obj as $key => $value ) {
                    if ($key != 'id' &&
                        $key != 'editado' &&
                        $key != 'criado') {
                        $query .= $key . ' = ';
                        if (is_numeric($value)) {
                            $query .= $value . ', ';
                        } else {
                            $query .= "'" .  $value . "', ";
                        }
                    } elseif ($key == 'id') {
                        $where .= $value;
                    } elseif ($key == 'editado') {
                        $dataHora = date('Y-m-d H:i:s');
                        $query .= "editado = '$dataHora'   ";
                    }
                }
                $query = substr($query, 0, strlen($query) - 2);
                $query .= ' ' . $where;
                $conn = connectarBanco();
                mysqli_query($conn, $query);
                $registros = mysqli_affected_rows($conn);


                return $registros == 1;
            } catch (\Throwable $th) {
                logErro($th->getMessage());
                desconnectarBanco($conn);
                return false;
            }
            
        }
    }
