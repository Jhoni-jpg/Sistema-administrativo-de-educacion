<?php

require_once __DIR__ . '/../../others/config/BDConnect.php';
require_once __DIR__ . '/../../others/utils/hashPassword.php';

class Login
{
    private \PDO $pdo;
    function __construct() {
        $bdConnect = new BDConnect();
        $this->pdo = $bdConnect->establecerConexion();
    }
    function register($user)
    {
        try {
            $conexion = $this->pdo;

            $sql = "INSERT INTO users(username, password, email)
        VALUES (?, ?, ?)";

            $stmt = $conexion->prepare($sql);

            $stmt->execute($user);

            return true;
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage();
            return false;
        }
    }

    function login($email, $password)
    {
        try {
            $conexion = $this->pdo;

            $sql = "SELECT username, email, password FROM users WHERE email = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$email]);
            
            $user = $stmt->fetch();

            if ($user) {
                if (!(new HashPassword())->unHash($password, $user['password'])) {
                    echo "Credenciales inválidas. Por favor, inténtalo de nuevo.";
                    return false;
                } else {
                    echo "Inicio de sesión exitoso. Bienvenido, " . $user['username'] . "!";
                    return true;
                }
            } else {
                echo "Credenciales inválidas. Por favor, inténtalo de nuevo.";
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al iniciar sesión: " . $e->getMessage();
        }
    }

    function getRol_database($email) {
        try {
            $sql = "SELECT rol FROM users WHERE email = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                return $user['rol'];
            } else {
                echo "Usuario no encontrado.";
                return null;
            }
        } catch (PDOException $e) {
            echo "Error al obtener el rol del usuario: " . $e->getMessage();
        }
    }

    function getUser_information($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<script>console.log(" . json_encode($users) . ")</script>";
            if ($users) {
                return $users;
            } else {
                echo "No se encontraron usuarios.";
                return [];
            }
        } catch (PDOException $e) {
            echo "Error al obtener la información del usuario: " . $e->getMessage();
        }
    }
}
