<?php

class Aluno 
{
    private $pdo;

    /**
     * Constructor to initialize PDO instance.
     */
    public function __construct() {
        $this->pdo = self::getConnection();
    }

    /**
     * Get all students with pagination.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function all($page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM alunos ORDER BY nome ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all students without pagination.
     *
     * @return array
     */
    public function allWithoutPagination() {
        $stmt = $this->pdo->query("SELECT * FROM alunos ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Search students by name with pagination.
     *
     * @param string $name
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function searchByName($name, $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT * FROM alunos WHERE nome LIKE :name ORDER BY nome ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find a student by ID.
     *
     * @param int $id
     * @return array|false
     */
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM alunos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new student.
     *
     * @param array $data
     * @throws \Exception
     */
    public function create($data) {
        self::validateData($data);
        $stmt = $this->pdo->prepare("INSERT INTO alunos (nome, data_nascimento, usuario) VALUES (?, ?, ?)");
        $stmt->execute([$data['nome'], $data['data_nascimento'], $data['usuario']]);
    }

    /**
     * Update an existing student.
     *
     * @param int $id
     * @param array $data
     * @throws \Exception
     */
    public function update($id, $data) {
        self::validateData($data);
        $stmt = $this->pdo->prepare("UPDATE alunos SET nome = ?, data_nascimento = ?, usuario = ? WHERE id = ?");
        $stmt->execute([$data['nome'], $data['data_nascimento'], $data['usuario'], $id]);
    }

    /**
     * Delete a student by ID.
     *
     * @param int $id
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM alunos WHERE id = ?");
        $stmt->execute([$id]);
    }

    /**
     * Get the total count of students.
     *
     * @return int
     */
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM alunos");
        return $stmt->fetchColumn();
    }

    /**
     * Get the count of students by name.
     *
     * @param string $name
     * @return int
     */
    public function countByName($name) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM alunos WHERE nome LIKE :name");
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    /**
     * Get the PDO connection.
     *
     * @return \PDO
     */
    private static function getConnection() {
        $root = dirname(__DIR__, 2);
        return require $root . '/config/database.php';
    }

    /**
     * Validate student data.
     *
     * @param array $data
     * @throws \Exception
     */
    private static function validateData($data) {
        $errors = [];
        if (empty($data['nome'])) {
            $errors[] = 'O nome do aluno deve ser preenchido.';
        }
        if (empty($data['data_nascimento'])) {
            $errors[] = 'A data de nascimento deve ser preenchida.';
        }
        if (empty($data['usuario'])) {
            $errors[] = 'O usuário deve ser preenchido.';
        }
        if (strlen($data['nome']) < 3) {
            $errors[] = 'O nome do aluno deve ter pelo menos 3 caracteres.';
        }
        if ($errors) {
            throw new Exception(implode(' ', $errors));
        }
    }
}