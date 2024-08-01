<?php

class Usuario 
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
     * Find a user by email.
     *
     * @param string $email
     * @return array|false
     */
    public function findByEmail(string $email) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            echo "Usuário encontrado: " . print_r($user, true);
        } else {
            echo "Nenhum usuário encontrado com o e-mail: $email";
        }
        return $user;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @throws \Exception
     */
    public function create(array $data) {
        $this->validateData($data);
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (?, ?)");
        if ($stmt->execute([$data['email'], $data['senha']])) {
            echo "Usuário criado com sucesso no banco de dados!";
        } else {
            echo "Falha ao criar usuário no banco de dados!";
        }
    }

    /**
     * Validate user data.
     *
     * @param array $data
     * @throws \Exception
     */
    private function validateData(array $data) {
        if (empty($data['email']) || empty($data['senha'])) {
            throw new Exception('Todos os campos devem ser preenchidos.');
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception('O e-mail fornecido é inválido.');
        }
    }

    /**
     * Verify user credentials.
     *
     * @param string $email
     * @param string $senha
     * @return array|false
     */
    public function verifyCredentials(string $email, string $senha) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($senha, $user['senha'])) {
            return $user;
        }
        return false;
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
}