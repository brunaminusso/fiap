<?php
$title = 'Listagem de Alunos';
ob_start();
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center" style="font-weight: 300; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
        Listagem de Alunos
    </h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="/alunos" method="get" class="form-inline">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nome" value="<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i> Buscar</button>
                    <?php if (isset($_GET['search']) && $_GET['search'] !== ''): ?>
                        <a href="/alunos" class="btn btn-outline-secondary ml-2"><i class="fas fa-times"></i> Limpar Filtro</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <a href="/alunos/create" class="btn btn-primary"><i class="fas fa-user-plus"></i> Cadastrar Novo Aluno</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr class="text-center">
                        <td><?php echo htmlspecialchars($aluno['nome']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($aluno['data_nascimento']))); ?></td>
                        <td>
                            <a href="/alunos/edit/<?php echo $aluno['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                            <form method="POST" action="/alunos/delete/<?php echo $aluno['id']; ?>" style="display: inline;" onsubmit="return confirm('Tem certeza de que deseja excluir este aluno?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars(isset($_GET['search']) ? $_GET['search'] : ''); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>