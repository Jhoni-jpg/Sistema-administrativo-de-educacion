<?php

require_once __DIR__ . '/../../others/config/BDConnect.php';
class PanelAdministrativo
{
    private $pdo;

    function __construct()
    {
        $conexion = new BDConnect();
        $this->pdo = $conexion->establecerConexion();
    }

    function addStudent($documento, $nombre, $apellido, $correo, $ficha, $programa)
    {
        try {
            $sql = 'INSERT INTO estudiantes VALUES (?, ?, ?, ?, ?, ?)';
        } catch (PDOException $err) {
            echo "Error en la insercion de datos. $err";
        }
    }

    function addPrograms($nameProgram)
    {
        try {
            $sql = 'INSERT INTO programas(nombre) VALUES (?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nameProgram]);

            return true;
        } catch (PDOException $err) {
            echo "Ha ocurrido un error inesperado en la insercion de datos: $err";
            return false;
        }
    }

    function getPrograms()
    {
        try {
            $sql = 'SELECT * FROM programas ORDER BY id ASC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            $values = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($values) {
                return $values;
            }

            return false;
        } catch (PDOException $err) {
            echo "Ha ocurrido un error inesperado en la insercion de datos: $err";
            return false;
        }
    }

    function dropProgram($id) {
        try {
            $sql = 'DELETE FROM programas WHERE id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);

            return true;
        } catch (PDOException $err) {
            echo "Ha ocurrido un error inesperado en la eliminacion de parametros: $err";
            return false;
        }
    }
}
