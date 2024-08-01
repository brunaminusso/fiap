<?php
$title = 'Gerenciar Matrículas';
ob_start();
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center" style="font-weight: 300; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
        Gerenciar Matrículas
    </h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div></div>
        <a href="/matriculas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Criar Matrícula</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th>ID Matrícula</th>
                    <th>Nome do Aluno</th>
                    <th>Nome da Turma</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matriculas as $matricula): ?>
                    <tr class="text-center">
                        <td><?php echo htmlspecialchars($matricula['matricula_id']); ?></td>
                        <td><?php echo htmlspecialchars($matricula['aluno_nome']); ?></td>
                        <td><?php echo htmlspecialchars($matricula['turma_nome']); ?></td>
                        <td>
                            <form method="POST" action="/matriculas/delete/<?php echo $matricula['matricula_id']; ?>" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja cancelar a matrícula?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">Cancelar Matrícula</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>