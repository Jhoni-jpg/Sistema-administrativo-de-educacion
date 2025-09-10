<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['cerrarSesion']) && $data['cerrarSesion'] == 'ok') {
        require __DIR__ . '/../others/utils/logout.php';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicio</title>
    <link rel="stylesheet" href="/../../public/styles/menuPrincipal.css">
</head>

<body class="bodyContainer">
    <?php
    require_once __DIR__ . '/../src/models/usersInformation.php';
    require_once __DIR__ . '/../src/service/login.php';
    require_once __DIR__ . '/../others/utils/getSessions.php';

    $userInformation = new usersInformation();
    $login = new login();
    $sessions = new GetSessions();

    if (!isset($_SESSION['rolUser'])) {
        header('Location: /?view=login');
        exit();
    } else {
        $nombre = $_SESSION['user_name'];
        $email = $_SESSION['emailUser'];
        $rol = $_SESSION['rolUser'];
    }
    ?>

    <section class="bodyContainer__sectionContent">
        <header class="bodyContainer__header">
            <div class="header__primaryContent">
                <div class="header__logo">
                    <a href="#"><span>
                            <?php if ($sessions->getRol() == 'user'): ?>
                                Educacion superior
                            <?php elseif ($sessions->getRol() == 'admin'): ?>
                                Panel administrativo
                            <?php endif; ?>
                        </span></a>
                </div>
                <div class="header__userActions">
                    <a href="/?view=login" class="userAction__logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                        </svg>
                    </a>
                    <div class="header__userAction">
                        <div class="activate">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" class="bi" viewBox="0 0 16 16">
                                <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="bodyContainer__mainContent">
            <section class="mainContent__sectionInformation">
                <div class="sectionInformation__userDetails">
                    <div class="sectionInformation__userImage">
                        <div>
                        </div>
                    </div>
                    <div class="sectionInformation__userData">
                        <div>
                            <h3>
                                Bienvenido <?= htmlspecialchars($nombre); ?>
                            </h3>
                        </div>
                        <div>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                                <?= htmlspecialchars($email) ?>
                            </span>
                        </div>
                        <div>
                            <h5><?= strtoupper($rol) ?></h5>
                        </div>
                    </div>
                </div>
                <?php if ($sessions->getRol() == 'user'): ?>
                    <div class="sectionInformation__userActions">
                        <div class="sectionInformation__userAction">
                            <div class="sectionInformation__action">
                                <div>
                                    <h3>⚙ Configuracion de perfil</h3>
                                </div>
                                <div>
                                    <p>Configuracion completa de tu perfil.</p>
                                </div>
                            </div>
                            <div class="sectionInformation__action">
                                <div>
                                    <h3>🎓 Perfil educativo</h3>
                                </div>
                                <div>
                                    <p>Visualiza tu estado actual en la institucion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($sessions->getRol() == 'admin'): ?>
                    <div class="sectionInformation__userActions">
                        <div class="sectionInformation__userAction">
                            <div class="sectionInformation__action">
                                <div>
                                    <h3>⚙ Configuracion de perfil</h3>
                                </div>
                                <div>
                                    <p>Configuracion completa de tu perfil.</p>
                                </div>
                            </div>
                            <div onclick="window.location.href = '/?view=panelAdministrativo'" class="sectionInformation__action tabulacionClass">
                                <div>
                                    <h3>🎓 Plataforma</h3>
                                </div>
                                <div>
                                    <p>Tabulacion de estudiantes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </section>

    <script src="/../../public/javascript/menuPrincipal.js" defer></script>
    <script src="/../others/APIS/redirects.js" defer></script>
    <script src="/../others/APIS/logout.js" defer></script>
</body>

</html>