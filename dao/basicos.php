<?php

function inserir($obj): int
{

    $query = 'INSERT INTO ' . $obj::TABELA . ' (';
    $colunas = '';
    $valores = '';
    foreach ( $obj as $key => $value ) {
        if ($key != 'id' &&
            $key != 'editado' &&
            $key != 'criado') {
            $colunas .= $key . ', ';
            $valores .= $value . ', ';
        } if ($key == 'criado') {
            $colunas .= $key;
            $valores .= "'" . date('Y-m-d H:i:s') . "'";
        }
    }
    $query = $query . $colunas . ') VALUES (' . $valores . ')';
    $conn = connectarBanco();
    $obj->id = mysqli_insert_id($conn);
    $result = mysqli_query($conn, $query);

    desconnectarBanco();
    echo $query;
    return $obj->id;
}

function carregar($id, $tabela)
{
    $query = "SELECT * FROM $tabela WHERE id = $id";

    $conn = connectarBanco();
    $result = mysqli_query($conn, $query);
    $registros = mysqli_num_rows($result);
    if ($registros == 1) {
        $row = mysqli_fetch_assoc($result);
        foreach ( $obj as $key => $value ) {
            $obj->key = $row[$key];
        }
    }

    desconnectarBanco();
	return $obj;

}