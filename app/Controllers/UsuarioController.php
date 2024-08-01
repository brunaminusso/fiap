<?php

class UsuarioController 
{
    private $usuarioModel;

    /**
     * Constructor.
     *
     * @param Usuario $usuarioModel An instance of the Usuario model.
     */
    public function __construct(Usuario $usuarioModel) {
        $this->usuarioModel = $usuarioModel;
    }

    public function showLoginForm() {
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'];

            $user = $this->usuarioModel->findByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];

                header('Location: /alunos');
                exit;
            } else {
                $error = 'Email ou senha inválidos.';
                require __DIR__ . '/../Views/auth/login.php';
            }
        } else {
            $this->showLoginForm();
        }
    }

    public function showRegistrationForm() {
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die('CSRF token validation failed');
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'];
        
            if ($this->usuarioModel->findByEmail($email)) {
                $error = 'Este e-mail já está registrado.';
                require __DIR__ . '/../Views/auth/register.php';
                return;
            }
        
            $senhaHash = password_hash($senha, PASSWORD_ARGON2ID);
        
            $data = [
                'email' => $email,
                'senha' => $senhaHash,
            ];
            $this->usuarioModel->create($data);
        
            header('Location: /login');
            exit;
        } else {
            $this->showRegistrationForm();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();

        header('Location: /login');
        exit;
    }
}
