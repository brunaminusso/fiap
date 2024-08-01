<?php
$title = 'Listagem de Turmas';
ob_start();
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center" style="font-weight: 300; border-bottom: 2px solid #dee2e6; padding-bottom: 10px;">
        Listagem de Turmas
    </h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="/turmas/create" class="btn btn-primary ml-auto"><i class="fas fa-plus"></i> Cadastrar Nova Turma</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="text-center">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turmas as $turma): ?>
                    <tr class="text-center">
                        <td><?php echo htmlspecialchars($turma['nome']); ?></td>
                        <td><?php echo htmlspecialchars($turma['descricao']); ?></td>
                        <td><?php echo htmlspecialchars($turma['tipo']); ?></td>
                        <td>
                            <a href="/turmas/edit/<?php echo $turma['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="/turmas/delete/<?php echo $turma['id']; ?>" method="post" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza de que deseja excluir esta turma?')">
                                    <i class="fas fa-trash-alt"></i> Excluir
                                </button>
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