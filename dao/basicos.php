<?php

function inserir($obj): int
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
        echo $query;
        $conn = connectarBanco();
        mysqli_query($conn, $query);
        $obj->id = mysqli_insert_id($conn);

        desconnectarBanco($conn);
        
        return $obj->id;
    } catch (\Throwable $th) {
        logErro($th->getMessage());
        return 0;
    }

    
}

function carregar(int $id, string $classe, string $tabela)
{
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
            return null;
        }

        desconnectarBanco($conn);
    } catch (\Throwable $th) {
        logErro($th->getMessage());
        return null;
    }
    
    
	return $obj;
}

function editar($obj): bool
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
        return false;
    }
    
}

function listar(string $classe, string $tabela, string $filtro = '', int $pagina = 0, int $limite = 10): array
{
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
        return $lista;
    }
}

function apagar(int $id, string $tabela): bool
{
    try {
        $query = "DELETE FROM $tabela WHERE id = $id";

        $conn = connectarBanco();
        mysqli_query($conn, $query);
        $registros = mysqli_affected_rows($conn);

        return $registros == 1;
    } catch (\Throwable $th) {
        logErro($th->getMessage());
        return false;
    }

}

function buscar(string $classe, string $tabela, string $filtro)
{
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
            return null;
        }

        desconnectarBanco($conn);
    } catch (\Throwable $th) {
        logErro($th->getMessage());
        return null;
    }

}