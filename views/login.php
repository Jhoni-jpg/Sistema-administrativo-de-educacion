<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/service/login.php';
require_once __DIR__ . '/../others/utils/captchat.php';
session_start();
$loginUser = new Login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset(
        $_POST['email'],
        $_POST['password']
    )) {
        echo 'Datos incompletos';
        return null;
    };

    $validationComplete = $loginUser->login($_POST['email'], $_POST['password']);
    $informacionUsuario = $loginUser->getUser_information($_POST['email']);

    if ($validationComplete && !empty($informacionUsuario)) {
        foreach ($informacionUsuario as $values) {
            $_SESSION['rolUser'] = $values['rol'];
            $_SESSION['emailUser'] = $values['email'];
            $_SESSION['user_name'] = $values['username'];
            $_SESSION['user_id'] = $values['id'];
        }


        header('Location: /?view=menuPrincipal');
        exit;
    } else {
        echo 'Credenciales incorrectas. Por favor, inténtalo de nuevo.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="/../public/styles/index.css">
</head>

<body>
    <main class="container w-100 h-100">
        <div class="d-flex justify-content-center align-items-center">
            <form action="/?view=login" method="POST">
                <div>
                    <h2>Inicio de sesion</h2>
                </div>
                <div class="mb-3">
                    <label for="idCorreo-sesion" class="form-label">Correo</label>
                    <input name="email" type="email" class="form-control" id="idCorreo-sesion" required>
                </div>
                <div class="mb-3">
                    <label for="idContraseña-sesion" class="form-label">Contraseña</label>
                    <input name="password" type="text" class="form-control" id="idContraseña-sesion" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="captcha" id="inputCheckbox-id" required>
                    <span>Obtener captcha</span>
                    <div class="divCaptcha_sectionInfo">
                        <div>
                            <h4>Captcha</h4>
                        </div>
                        <div>
                            <p>Asegurate de seguir las instrucciones del captcha</p>
                        </div>
                        <div>
                            <?php
                            echo "{$codigoGenerado}";
                            ?>
                        </div>
                        <div>
                            <input type="text" placeholder="Ingrese el captcha" required>
                        </div>
                        <div><button>Aceptar</button></div>
                    </div>
                </div>
                <div>
                    <a href="/?view=registro">Registrarse</a>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </main>

    <script src="public/javascript/index.js"></script>
</body>

</html>