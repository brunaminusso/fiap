<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Matrícula</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .nav-item .nav-link {
            font-size: 1.2rem;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <?php
    $title = 'Cadastrar Matrícula';
    ob_start();
    ?>

    <div class="container mt-4">
        <h1 class="mb-4 text-center" style="font-weight: 300; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
            Cadastrar Matrícula
        </h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form action="/matriculas/store" method="post">
                <div class="form-group">
                    <label for="aluno_id">Aluno</label>
                    <select id="aluno_id" name="aluno_id" class="form-control" required>
                        <?php foreach ($alunos as $aluno): ?>
                            <option value="<?php echo htmlspecialchars($aluno['id']); ?>">
                                <?php echo htmlspecialchars($aluno['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="turma_id">Turma</label>
                    <select id="turma_id" name="turma_id" class="form-control" required>
                        <?php foreach ($turmas as $turma): ?>
                            <option value="<?php echo htmlspecialchars($turma['id']); ?>">
                                <?php echo htmlspecialchars($turma['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="/matriculas" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
