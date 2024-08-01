<?php

require_once __DIR__ . '/../Models/Turma.php';

class TurmaController
{
    private $turmaModel;

    /**
     * Constructor.
     *
     * @param Turma $turmaModel An instance of the Turma model.
     */
    public function __construct(Turma $turmaModel)
    {
        $this->turmaModel = $turmaModel;
    }

    public function index(): void {
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';

        $perPage = 5;
        $total = $this->turmaModel->count($search);
        $totalPages = ceil($total / $perPage);

        $turmas = $this->turmaModel->all((int)$page, $perPage, $search);

        $this->render('index', compact('turmas', 'totalPages', 'page', 'search'));
    }

    public function create(): void {
        $this->render('create');
    }

    public function store(): void {
        try {
            $this->turmaModel->create($_POST);
            $this->redirect('/turmas');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->render('create', compact('error', 'data'));
        }
    }

    public function edit(int $id): void {
        $turma = $this->turmaModel->find($id);
        $this->render('edit', compact('turma'));
    }

    public function update(int $id): void {
        try {
            $this->turmaModel->update($id, $_POST);
            $this->redirect('/turmas');
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }

    public function delete(int $id): void {
        try {
            $this->turmaModel->delete($id);
            $this->redirect('/turmas');
        } catch (Exception $e) {
            echo 'Erro: ' . $e->getMessage();
        }
    }

    private function redirect(string $url): void {
        header("Location: $url");
        exit;
    }

    private function render(string $view, array $data = []): void {
        extract($data);
        require __DIR__ . "/../Views/turmas/$view.php";
    }
}