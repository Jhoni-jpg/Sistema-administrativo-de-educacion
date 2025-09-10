    <?php
    require_once __DIR__ . '/../src/service/login.php';
    require_once __DIR__ . '/../others/utils/hashPassword.php';

    $registerUser = new login();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset(
            $_POST['username'],
            $_POST['password'],
            $_POST['email']
        )) {
            echo 'Datos incompletos';
            exit;
        };

        $passwordHasher = new hashPassword();
        $_POST['password'] = $passwordHasher->hash($_POST['password']);

        $validationRegister = $registerUser->register([
            $_POST['username'],
            $_POST['password'],
            $_POST['email']
        ]);

        if (is_bool($validationRegister) && $validationRegister) {
            header('Location: /?view=login');
            exit;
        }
    }
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Registro</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>

    <body class="registro-body">
        <section class="bodySection__contentDiv">
            <div class="contentDiv__formContent">
                <form class="formContent" action="/?view=registro" method="POST">
                    <div>
                        <h2>Registro</h2>
                    </div>
                    <div>
                        <input name="username" type="text" required>
                    </div>
                    <div>
                        <input name="email" type="email" required>
                    </div>
                    <div>
                        <input name="password" type="text" required>
                    </div>
                    <div>
                        <button type="submit">Registrar</button>
                    </div>
                </form>
            </div>
        </section>
    </body>

    </html>