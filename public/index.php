<?php
session_start();

require_once __DIR__ . '/../config/session.php';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Aluno.php';
require_once __DIR__ . '/../app/Models/Turma.php';
require_once __DIR__ . '/../app/Models/Matricula.php';
require_once __DIR__ . '/../app/Models/Usuario.php';

require_once __DIR__ . '/../app/Controllers/AlunoController.php';
require_once __DIR__ . '/../app/Controllers/TurmaController.php';
require_once __DIR__ . '/../app/Controllers/MatriculaController.php';
require_once __DIR__ . '/../app/Controllers/UsuarioController.php';

$pdo = require __DIR__ . '/../config/database.php';

$alunoModel = new Aluno($pdo);
$turmaModel = new Turma($pdo);
$matriculaModel = new Matricula($pdo);
$usuarioModel = new Usuario($pdo);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$rotaProtegida = [
    '/alunos', '/alunos/create', '/alunos/store', '/alunos/edit', '/alunos/update', '/alunos/delete',
    '/turmas', '/turmas/create', '/turmas/store', '/turmas/edit', '/turmas/update', '/turmas/delete',
    '/matriculas', '/matriculas/create', '/matriculas/store', '/matriculas/delete'
];

if (in_array($path, $rotaProtegida) && !isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

if ($path === '/' || $path === '') {
    header('Location: /login');
    exit;
}

switch ($path) {
    case '/alunos':
        $controller = new AlunoController($alunoModel);
        $controller->index();
        break;
    case '/alunos/create':
        $controller = new AlunoController($alunoModel);
        $controller->create();
        break;
    case '/alunos/store':
        $controller = new AlunoController($alunoModel);
        $controller->store();
        break;
    case (preg_match('/\/alunos\/edit\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new AlunoController($alunoModel);
        $controller->edit($id);
        break;
    case (preg_match('/\/alunos\/update\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new AlunoController($alunoModel);
        $controller->update($id);
        break;
    case (preg_match('/\/alunos\/delete\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new AlunoController($alunoModel);
        $controller->delete($id);
        break;

    case '/turmas':
        $controller = new TurmaController($turmaModel);
        $controller->index();
        break;
    case '/turmas/create':
        $controller = new TurmaController($turmaModel);
        $controller->create();
        break;
    case '/turmas/store':
        $controller = new TurmaController($turmaModel);
        $controller->store();
        break;
    case (preg_match('/\/turmas\/edit\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new TurmaController($turmaModel);
        $controller->edit($id);
        break;
    case (preg_match('/\/turmas\/update\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new TurmaController($turmaModel);
        $controller->update($id);
        break;
    case (preg_match('/\/turmas\/delete\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new TurmaController($turmaModel);
        $controller->delete($id);
        break;

    case '/matriculas':
        $controller = new MatriculaController($matriculaModel, $alunoModel);
        $controller->index();
        break;
    case '/matriculas/create':
        $controller = new MatriculaController($matriculaModel, $alunoModel);
        $controller->create();
        break;
    case '/matriculas/store':
        $controller = new MatriculaController($matriculaModel, $alunoModel);
        $controller->store();
        break;
    case (preg_match('/\/matriculas\/delete\/\d+/', $path) ? true : false):
        $id = explode('/', $path)[3];
        $controller = new MatriculaController($matriculaModel, $alunoModel);
        $controller->delete($id);
        break;

    case '/login':
        $controller = new UsuarioController($usuarioModel);
        if ($method == 'GET') {
            $controller->showLoginForm();
        } elseif ($method == 'POST') {
            $controller->login();
        }
        break;
    case '/logout':
        $controller = new UsuarioController($usuarioModel);
        $controller->logout();
        break;
    case '/register':
        $controller = new UsuarioController($usuarioModel);
        if ($method == 'GET') {
            $controller->showRegistrationForm();
        } elseif ($method == 'POST') {
            $controller->register();
        }
        break;

    default:
        echo "Página não encontrada";
        break;
}