<?php

class Matricula
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
     * Get all enrollments with student and course names.
     *
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getAllEnrollments($page = 1, $limit = 5)
    {
        $offset = ($page - 1) * $limit;
        $query = "
            SELECT m.id AS matricula_id, a.nome AS aluno_nome, c.nome AS turma_nome
            FROM matriculas m
            JOIN alunos a ON m.aluno_id = a.id
            JOIN turmas c ON m.turma_id = c.id
            ORDER BY m.id ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total count of enrollments.
     *
     * @return int
     */
    public function getTotalCount()
    {
        $query = "SELECT COUNT(*) FROM matriculas";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }

    /**
     * Get all available courses.
     *
     * @return array
     */
    public function getAllCourses()
    {
        $stmt = $this->pdo->query("SELECT id, nome FROM turmas ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if an enrollment already exists.
     *
     * @param int $alunoId
     * @param int $turmaId
     * @return bool
     */
    public function enrollmentExists($alunoId, $turmaId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM matriculas WHERE aluno_id = ? AND turma_id = ?");
        $stmt->execute([$alunoId, $turmaId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Create a new enrollment.
     *
     * @param int $alunoId
     * @param int $turmaId
     * @return void
     * @throws \Exception
     */
    public function createEnrollment($alunoId, $turmaId)
    {
        if ($this->enrollmentExists($alunoId, $turmaId)) {
            throw new Exception('O aluno já está matriculado nesta turma.');
        }

        $stmt = $this->pdo->prepare("INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)");
        $stmt->execute([$alunoId, $turmaId]);
    }

    /**
     * Delete an enrollment.
     *
     * @param int $matriculaId
     * @return void
     * @throws \Exception
     */
    public function deleteEnrollment($matriculaId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM matriculas WHERE id = ?");
        $stmt->execute([$matriculaId]);
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