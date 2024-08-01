<?php

require_once __DIR__ . '/../Models/Aluno.php';

class AlunoController 
{
    private $alunoModel;

    /**
     * AlunoController constructor.
     * @param Aluno $alunoModel
     */
    public function __construct(Aluno $alunoModel) {
        $this->alunoModel = $alunoModel;
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 10;
        $search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

        if ($search) {
            $alunos = $this->alunoModel->searchByName($search, $page, $perPage);
            $total = $this->alunoModel->countByName($search);
        } else {
            $alunos = $this->alunoModel->all($page, $perPage);
            $total = $this->alunoModel->count();
        }

        $totalPages = ceil($total / $perPage);

        $this->render('index', compact('alunos', 'totalPages', 'page', 'search'));
    }

    public function create() {
        $this->render('create');
    }

    public function store() {
        $data = [
            'nome' => isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '',
            'data_nascimento' => isset($_POST['data_nascimento']) ? htmlspecialchars($_POST['data_nascimento']) : '',
            'usuario' => isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''
        ];

        try {
            $this->alunoModel->create($data);
            $this->redirect('/alunos');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->render('create', compact('error', 'data'));
        }
    }

    public function edit(int $id) {
        $aluno = $this->alunoModel->find($id);
        if ($aluno === false) {
            $this->redirect('/alunos');
        }
        $this->render('edit', compact('aluno'));
    }

    public function update(int $id) {
        $data = [
            'nome' => isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '',
            'data_nascimento' => isset($_POST['data_nascimento']) ? htmlspecialchars($_POST['data_nascimento']) : '',
            'usuario' => isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''
        ];

        try {
            $this->alunoModel->update($id, $data);
            $this->redirect('/alunos');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $aluno = $this->alunoModel->find($id);
            $this->render('edit', compact('error', 'aluno', 'data'));
        }
    }

    public function delete(int $id) {
        try {
            $this->alunoModel->delete($id);
            $this->redirect('/alunos');
        } catch (Exception $e) {
            echo "Erro: " . htmlspecialchars($e->getMessage());
        }
    }

    private function redirect(string $url) {
        header("Location: $url");
        exit;
    }

    private function render(string $view, array $data = []) {
        extract($data);
        require __DIR__ . "/../Views/alunos/$view.php";
    }
}