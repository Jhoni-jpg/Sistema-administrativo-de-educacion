<?php
require_once __DIR__ . '/../../src/service/panelAdministrativo.php';

$panelAdministrativo = new PanelAdministrativo();
$var = [];
$programs = [];

if (!isset($_SESSION['rolUser']) && !$_SESSION['rolUser'] == 'admin') {
    header('Location: /?view=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data) && isset($data['listarProgramas']) && strtolower(trim($data['listarProgramas'])) == 'ok') {
        $programs = $panelAdministrativo->getPrograms();

        if (is_array($programs) && !empty($programs)) {
            echo json_encode($programs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        } else {
            echo json_encode([
                'estado' => 'error'
            ]);
            exit;
        }
    }

    if (is_array($data) && isset($data['num'])) {
        $number = $data['num'];

        if (is_int($number) && !empty($number)) {
            echo json_encode([
                'estado' => 'ok',
                'mensaje' => $number
            ]);
            exit;
        } else {
            echo json_encode([
                'estado' => 'error',
                'mensaje' => 'Ha ocurrido un error inesperado en la comunicacion'
            ]);
            exit;
        }
    }

    if (isset($_POST['programName']) && !empty($_POST['programName'])) {
        $agregadoCorrectamente = $panelAdministrativo->addPrograms(strtolower(trim($_POST['programName'])));
        header("Location: /?view=panelAdministrativo&added=1");
        exit;
    }

    if (isset($_POST['dropProgram'])) {
        $programaEliminado = $panelAdministrativo->dropProgram($_POST['id_program']);
        header("Location: /?view=panelAdministrativo&delete=1");
        exit;
    }
}
?>

<section class="container h-100">
    <main class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
        <div class="sectionContent__div-first mb-2 d-flex justify-content-start flex-column w-100 mb-5">
            <div>
                <h3>Agregar programas</h3>
            </div>
            <div>
                <div class="d-flex justify-content-center align-items-center w-100">
                    <form class="input-group" action="/?view=panelAdministrativo" method="post">
                        <input name="programName" type="text" class="form-control addProgram__class" aria-label="Text input with segmented dropdown button">
                        <button type="submit" class="btn btn-outline-secondary">Agregar</button>
                    </form>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split mx-3 listPrograms__toggleButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                    </ul>
                </div>
                <div class="d-flex justify-content-center align-items-center w-100">

                </div>
            </div>
        </div>
        <div class="sectionContent__div-second mb-2 d-flex justify-content-start w-100">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal__addStudent-id">
                Add student
            </button>
        </div>
        <div class="sectionContent__div-three d-flex justify-content-center w-100">

            <table class="table table-striped-columns tablee-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">
                            ID
                        </th>
                        <th scope="col">
                            DOCUMENTO
                        </th>
                        <th scope="col">
                            NOMBRE
                        </th>
                        <th scope="col">
                            APELLIDO
                        </th>
                        <th scope="col">
                            CORREO
                        </th>
                        <th scope="col">
                            FICHA
                        </th>
                        <th scope="col">
                            PROGRAMA
                        </th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($var) && !empty($var)): ?>
                        <?php foreach ($var as $values): ?>
                            <tr>
                                <th scope="row">1</th>
                                <td contenteditable="true">2</td>
                                <td contenteditable="true">3</td>
                                <td contenteditable="true">4</td>
                                <td contenteditable="true">5</td>
                                <td contenteditable="true">6</td>
                                <td contenteditable="true">7</td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-secondary m-2">
                                        Show
                                    </button>
                                    <button class="btn btn-danger m-2">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="align-middle text-center bg-light">No hay registros disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="modal fade" id="modal__addStudent-id" tabindex="-1" aria-labelledby="modalStuden-add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Student register</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameStudent" class="col-form-label">Documento</label>
                            <input type="number" class="form-control" id="nameStudent" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-center align-items-start w-100 h-100 mb-1">
                                <span class="w-100">
                                    Nombre
                                </span>
                                <span class="w-100">
                                    Apellido
                                </span>
                            </div>
                            <div class="input-group">
                                <input type="text" aria-label="First name" id="nameStudent" class="form-control" required>
                                <input type="text" aria-label="Last name" id="lastnameStudent" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="emailStudent" class="col-form-label">Correo</label>

                            <div class="input-group">
                                <input type="text" id="emailStudent" class="form-control" placeholder="Identificador" aria-label="Identificador de Correo" aria-describedby="basic-addon2" required>
                                <span class="input-group-text" id="basic-addon2">@gmail.com</span>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="programStudent" class="col-form-label">Programa</label>
                            <input class="form-control" id="programsList-id" list="programs" name="programsAvaible" required>
                            <datalist id="programs">
                                <option value="">
                            </datalist>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>