<?php

class Turma
{
    private $pdo;

    /**
     * Constructor to initialize PDO instance.
     */
    public function __construct()
    {
        $this->pdo = self::getConnection();
    }

    /**
     * Get all turmas with pagination.
     *
     * @param int $page The page number to retrieve.
     * @param int $perPage The number of items per page.
     * @return array An array of turmas.
     */
    public function all($page = 1, $perPage = 5)
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare("SELECT * FROM turmas ORDER BY nome ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of turmas.
     *
     * @return int The count of turmas.
     */
    public function count()
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM turmas");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Find a turma by its ID.
     *
     * @param int $id The ID of the turma to find.
     * @return array|null The turma data or null if not found.
     */
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM turmas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new turma.
     *
     * @param array $data The data for the new turma.
     * @throws \Exception If validation fails.
     */
    public function create($data)
    {
        $this->validateData($data);

        $stmt = $this->pdo->prepare("INSERT INTO turmas (nome, descricao, tipo) VALUES (?, ?, ?)");
        $stmt->execute([$data['nome'], $data['descricao'], $data['tipo']]);
    }

    /**
     * Update an existing turma.
     *
     * @param int $id The ID of the turma to update.
     * @param array $data The updated data for the turma.
     * @throws \Exception If validation fails.
     */
    public function update($id, $data)
    {
        $this->validateData($data);

        $stmt = $this->pdo->prepare("UPDATE turmas SET nome = ?, descricao = ?, tipo = ? WHERE id = ?");
        $stmt->execute([$data['nome'], $data['descricao'], $data['tipo'], $id]);
    }

    /**
     * Delete a turma by its ID.
     *
     * @param int $id The ID of the turma to delete.
     * @throws \Exception If the turma is not found.
     */
    public function delete($id)
    {
        // Check if the turma exists before deleting
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM turmas WHERE id = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception('Turma não encontrada.');
        }

        $stmt = $this->pdo->prepare("DELETE FROM turmas WHERE id = ?");
        $stmt->execute([$id]);
    }

    /**
     * Get all turmas without pagination.
     *
     * @return array An array of turmas.
     */
    public function allWithoutPagination()
    {
        $stmt = $this->pdo->query("SELECT * FROM turmas ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Validate turma data.
     *
     * @param array $data The data to validate.
     * @throws \Exception If validation fails.
     */
    private function validateData($data)
    {
        if (empty($data['nome']) || empty($data['descricao']) || empty($data['tipo'])) {
            throw new Exception('Todos os campos devem ser preenchidos.');
        }

        if (strlen($data['nome']) < 3) {
            throw new Exception('O nome da turma deve ter pelo menos 3 caracteres.');
        }
    }

    /**
     * Get the PDO connection.
     *
     * @return \PDO
     */
    private static function getConnection()
    {
        $root = dirname(__DIR__, 2);
        return require $root . '/config/database.php';
    }
}