<?php
require_once __DIR__ . '/../service/panelAdministrativo.php';
class AuthController
{
    public function jsonResponse($data, $codeResponse = 200)
    {
        http_response_code($codeResponse);
        header('Content-Type: application/json');
        $data = array_merge(['status' => 'ok'], $data);
        echo json_encode($data);
        exit;
    }

    public function estudiantes()
    {
        $service = new PanelAdministrativo();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!empty($data) && isset($data['listarProgramas']) && strtolower(trim($data['listarProgramas'])) == 'ok') {
                $programs = $service->getPrograms();

                if (is_array($programs) && !empty($programs)) {
                    $this->jsonResponse($programs);
                } else {
                    $this->jsonResponse(['status' => 'error', 'message' => 'Error en la validacion de parametros'], 401);
                }
            }

            if (is_array($data) && isset($data['num'])) {
                $number = $data['num'];

                if (is_int($number) && !empty($number)) {
                    $this->jsonResponse($number);
                } else {
                    $this->jsonResponse(['status' => 'error', 'message' => 'Error en la validacion de parametros'], 401);
                }
            }

            if (isset($_POST['programName']) && !empty($_POST['programName'])) {
                $agregadoCorrectamente = $service->addPrograms(strtolower(trim($_POST['programName'])));

                if ($agregadoCorrectamente) {
                    $this->jsonResponse(['status' => 'ok']);
                } else {
                    $this->jsonResponse(['status' => 'error', 'message' => 'Ha ocurrido un error en la obtencion de datos'], 401);
                }
            }

            if (isset($_POST['dropProgram'])) {
                $programaEliminado = $service->dropProgram($_POST['id_program']);

                if ($programaEliminado) {
                    $this->jsonResponse(['status' => 'ok']);
                } else {
                    $this->jsonResponse(['status' => 'error', 'message' => 'Ha ocurrido un error en la eliminacion de valores'], 401);
                }
            }
        }
    }
}
