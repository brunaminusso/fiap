<?php

require_once __DIR__ . '/../Models/Matricula.php';
require_once __DIR__ . '/../Models/Aluno.php';

class MatriculaController
{
    private $matriculaModel;
    private $alunoModel;

    /**
     * MatriculaController constructor.
     *
     * @param Matricula $matriculaModel
     * @param Aluno $alunoModel
     */
    public function __construct(Matricula $matriculaModel, Aluno $alunoModel)
    {
        $this->matriculaModel = $matriculaModel;
        $this->alunoModel = $alunoModel;
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $totalMatriculas = $this->matriculaModel->getTotalCount();
        $totalPages = ceil($totalMatriculas / $limit);
        $matriculas = $this->matriculaModel->getAllEnrollments($page, $limit);
        $this->render('index', compact('matriculas', 'page', 'totalPages'));
    }

    public function create()
    {
        $turmas = $this->matriculaModel->getAllCourses();
        $alunos = $this->alunoModel->allWithoutPagination();
        $this->render('create', compact('turmas', 'alunos'));
    }

    public function store()
    {
        $alunoId = $_POST['aluno_id'] ?? null;
        $turmaId = $_POST['turma_id'] ?? null;

        try {
            $this->matriculaModel->createEnrollment($alunoId, $turmaId);
            $this->redirect('/matriculas');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $turmas = $this->matriculaModel->getAllCourses();
            $alunos = $this->alunoModel->allWithoutPagination();
            $this->render('create', compact('error', 'turmas', 'alunos'));
        }
    }

    public function delete($id)
    {
        try {
            $this->matriculaModel->deleteEnrollment($id);
            $this->redirect('/matriculas');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $totalMatriculas = $this->matriculaModel->getTotalCount();
            $totalPages = ceil($totalMatriculas / $limit);
            $matriculas = $this->matriculaModel->getAllEnrollments($page, $limit);
            $this->render('index', compact('matriculas', 'page', 'totalPages', 'error'));
        }
    }

    private function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }

    private function render(string $view, array $data = [])
    {
        extract($data);
        require __DIR__ . "/../Views/matriculas/$view.php";
    }
}