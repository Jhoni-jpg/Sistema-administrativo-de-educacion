<?php
require_once __DIR__ . '/../src/service/login.php';

session_start();
ob_start();

if (!isset($_SESSION['rolUser'])) {
    header('Location: /?view=login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data) && isset($data['typeOption'])) {
        $menuEscogido = $data['typeOption'];

        switch ($menuEscogido) {
            case 'estudiante':
                include __DIR__ . '/components/gestionEstudiantes.php';
                $htmlFragment = ob_get_clean();
                header('Content-type: application/json');
                echo json_encode(['status' => 'ok', 'html' => $htmlFragment]);
                exit;
            default:
                header('Content-type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Opcion del menu no encontrada o no disponible']);
                exit;
        }
    }
}

// Datos simulados para estadísticas
$stats = [
    'total_usuarios' => 2680,
    'usuarios_activos' => 2450,
    'nuevos_registros' => 150,
    'sesiones_mes' => 15420,
    'promedio_notas' => 8.4,
    'cursos_activos' => 124
];

// Historial de actividades recientes
$historial = [
    [
        'fecha' => '2024-09-04 14:30:00',
        'accion' => 'Nuevo estudiante registrado',
        'usuario' => 'María González',
        'tipo' => 'registro'
    ],
    [
        'fecha' => '2024-09-04 13:45:00',
        'accion' => 'Calificación actualizada',
        'usuario' => 'Prof. Carlos Ruiz',
        'tipo' => 'calificacion'
    ],
    [
        'fecha' => '2024-09-04 12:20:00',
        'accion' => 'Configuración modificada',
        'usuario' => 'Admin Sistema',
        'tipo' => 'configuracion'
    ],
    [
        'fecha' => '2024-09-04 11:15:00',
        'accion' => 'Backup realizado',
        'usuario' => 'Sistema',
        'tipo' => 'sistema'
    ],
    [
        'fecha' => '2024-09-04 10:30:00',
        'accion' => 'Nuevo curso creado',
        'usuario' => 'Prof. Ana Martín',
        'tipo' => 'curso'
    ]
];

// Función para formatear fecha
function formatearFecha($fecha)
{
    $timestamp = strtotime($fecha);
    return date('d/m/Y H:i', $timestamp);
}

// Función para obtener icono según tipo de actividad
function obtenerIcono($tipo)
{
    $iconos = [
        'registro' => '👤',
        'calificacion' => '📝',
        'configuracion' => '⚙️',
        'sistema' => '🔧',
        'curso' => '📚'
    ];
    return $iconos[$tipo] ?? '📋';
}

// Función para obtener color según el tipo
function obtenerColor($tipo)
{
    $colores = [
        'registro' => 'success',
        'calificacion' => 'primary',
        'configuracion' => 'warning',
        'sistema' => 'info',
        'curso' => 'secondary'
    ];
    return $colores[$tipo] ?? 'light';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header h4 {
            color: white;
            margin-bottom: 0.5rem;
        }

        .user-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .nav-section {
            padding: 1rem 0;
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }

        .nav-item {
            margin: 0.2rem 0;
        }

        .nav-link {
            color: white !important;
            padding: 0.8rem 1.5rem;
            border-radius: 0;
            transition: all 0.3s ease;
            border: none;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #ffc107;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            backdrop-filter: blur(10px);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }

        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .config-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            padding: 0.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .config-label {
            color: white;
            font-size: 0.9rem;
        }

        .history-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            padding: 0.8rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid #ffc107;
        }

        .history-time {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .history-action {
            color: white;
            font-size: 0.8rem;
            margin: 0.2rem 0;
        }

        .history-user {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .collapse-content {
            padding: 1rem 1.5rem;
        }

        .btn-sidebar {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }

        .btn-sidebar:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .main-content {
            margin-left: 300px;
            padding: 2rem;
            min-height: 100vh;
            background: #f8f9fa;
        }

        .toggle-sidebar {
            position: absolute;
            top: 1rem;
            right: -20px;
            background: #667eea;
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            z-index: 1001;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <button class="toggle-sidebar d-md-none" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>

        <!-- Header del Sidebar -->
        <div class="sidebar-header">
            <h4><i class="fas fa-graduation-cap"></i> Instituto Superior</h4>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <?= htmlspecialchars($_SESSION['user_name']); ?><br>
                <small><?= ucfirst($_SESSION['rolUser']); ?></small>
            </div>
        </div>

        <!-- Navegación Principal -->
        <nav class="nav-section">
            <div class="nav-section-title">Navegación</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active sidebar__listOptions" data-option="dashboard" href="#dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar__listOptions" data-option="estudiante" href="#">
                        <i class="fas fa-users me-2"></i> Estudiantes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar__listOptions" data-option="curso" href="#cursos">
                        <i class="fas fa-book me-2"></i> Cursos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebar__listOptions" data-option="dashboard" href="#reportes">
                        <i class="fas fa-chart-bar me-2"></i> Reportes
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sección de Configuración -->
        <div class="nav-section">
            <div class="nav-section-title">
                <a class="text-decoration-none text-light" data-bs-toggle="collapse" href="#configSection" role="button">
                    <i class="fas fa-cog"></i> Configuración
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
            </div>
            <div class="collapse" id="configSection">
                <div class="collapse-content">
                    <?php
                    $configuraciones = [
                        ['label' => 'Modo Oscuro', 'value' => false, 'type' => 'switch'],
                        ['label' => 'Idioma', 'value' => 'Español', 'type' => 'select']
                    ];

                    foreach ($configuraciones as $config): ?>
                        <div class="config-item">
                            <span class="config-label"><?php echo $config['label']; ?></span>
                            <?php if ($config['type'] == 'switch'): ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox"
                                        <?php echo $config['value'] ? 'checked' : ''; ?>>
                                </div>
                            <?php elseif ($config['type'] == 'select'): ?>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>Español</option>
                                </select>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Sección de Estadísticas -->
        <div class="nav-section">
            <div class="nav-section-title">
                <a class="text-decoration-none text-light" data-bs-toggle="collapse" href="#statsSection" role="button">
                    <i class="fas fa-chart-line"></i> Estadísticas
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
            </div>
            <div class="collapse show" id="statsSection">
                <div class="collapse-content">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo number_format($stats['total_usuarios']); ?></div>
                        <div class="stat-label">Total Usuarios</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number"><?php echo number_format($stats['usuarios_activos']); ?></div>
                        <div class="stat-label">Usuarios Activos</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number">+<?php echo number_format($stats['nuevos_registros']); ?></div>
                        <div class="stat-label">Nuevos Este Mes</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-number"><?php echo $stats['promedio_notas']; ?></div>
                        <div class="stat-label">Promedio General</div>
                    </div>

                    <button class="btn btn-sidebar btn-sm w-100 mt-2">
                        <i class="fas fa-download me-1"></i> Exportar Datos
                    </button>
                </div>
            </div>
        </div>

        <!-- Sección de Historial -->
        <div class="nav-section">
            <div class="nav-section-title">
                <a class="text-decoration-none text-light" data-bs-toggle="collapse" href="#historySection" role="button">
                    <i class="fas fa-history"></i> Historial
                    <i class="fas fa-chevron-down float-end mt-1"></i>
                </a>
            </div>
            <div class="collapse show" id="historySection">
                <div class="collapse-content">
                    <?php foreach (array_slice($historial, 0, 5) as $item): ?>
                        <div class="history-item">
                            <div class="history-time">
                                <?php echo formatearFecha($item['fecha']); ?>
                            </div>
                            <div class="history-action">
                                <?php echo obtenerIcono($item['tipo']); ?>
                                <?php echo htmlspecialchars($item['accion']); ?>
                            </div>
                            <div class="history-user">
                                Por: <?php echo htmlspecialchars($item['usuario']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button class="btn btn-sidebar btn-sm w-100 mt-2">
                        <i class="fas fa-list me-1"></i> Ver Todo el Historial
                    </button>
                </div>
            </div>
        </div>

        <!-- Acciones del Sistema -->
        <div class="nav-section">
            <div class="nav-section-title">Sistema</div>
            <div class="collapse-content">
                <button class="btn btn-sidebar btn-sm w-100 mb-2">
                    <i class="fas fa-sync me-1"></i> Sincronizar Datos
                </button>
                <button class="btn btn-sidebar btn-sm w-100 mb-2">
                    <i class="fas fa-sign-out-alt me-1"></i> Regresar
                </button>
            </div>
        </div>
    </aside>

    <!-- Contenido Principal -->
    <main class="main-content">
        <button class="btn btn-primary d-md-none mb-3" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i> Menú
        </button>

        <section class="mainContent__sectionInformation">

        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Auto-actualizar estadísticas cada 30 segundos
        setInterval(function() {
            // Aquí puedes hacer una petición AJAX para actualizar las estadísticas
            console.log('Actualizando estadísticas...');
        }, 30000);

        // Manejar clicks en el menú
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Remover clase active de todos los links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

                // Agregar clase active al link clickeado
                this.classList.add('active');

                // Aquí puedes agregar la lógica para cambiar el contenido
                const section = this.getAttribute('href').replace('#', '');
                console.log('Navegando a:', section);
            });
        });
    </script>
    <script src="/../others/APIS/event_panelAdministrativo.js" type="module"></script>
</body>

</html>