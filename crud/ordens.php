<?php
// crud/ordens.php
include '../includes/config.php';

// Operações CRUD para ordens de serviço
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO ordem_servico (cliente_id, tecnico_id, data_abertura, status) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['cliente_id'], $_POST['tecnico_id'], $_POST['data_abertura'], $_POST['status']]);
        header("Location: ordens.php?success=Ordem de serviço adicionada com sucesso!");
        exit;
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE ordem_servico SET cliente_id=?, tecnico_id=?, data_abertura=?, data_fechamento=?, status=? WHERE id=?");
        $stmt->execute([$_POST['cliente_id'], $_POST['tecnico_id'], $_POST['data_abertura'], $_POST['data_fechamento'], $_POST['status'], $_POST['id']]);
        header("Location: ordens.php?success=Ordem de serviço atualizada com sucesso!");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM ordem_servico WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: ordens.php?success=Ordem de serviço excluída com sucesso!");
    exit;
}

// Buscar ordem para edição
$edit_ordem = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM ordem_servico WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_ordem = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar ordens com informações relacionadas
$stmt = $pdo->query("
    SELECT os.*, c.nome as cliente_nome, t.nome as tecnico_nome 
    FROM ordem_servico os 
    LEFT JOIN cliente c ON os.cliente_id = c.id 
    LEFT JOIN tecnico t ON os.tecnico_id = t.id 
    ORDER BY os.id DESC
");
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar clientes e técnicos para os selects
$stmt_clientes = $pdo->query("SELECT id, nome FROM cliente ORDER BY nome");
$clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);

$stmt_tecnicos = $pdo->query("SELECT id, nome FROM tecnico ORDER BY nome");
$tecnicos = $stmt_tecnicos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordens de Serviço - WIERZNACKA.INFO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container">
        <h1>Gerenciar Ordens de Serviço</h1>
        
        <div class="form-container">
            <h2><?php echo $edit_ordem ? 'Editar Ordem de Serviço' : 'Adicionar Nova Ordem de Serviço'; ?></h2>
            <form method="POST">
                <?php if ($edit_ordem): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_ordem['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="cliente_id">Cliente *</label>
                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>" 
                                <?php echo ($edit_ordem && $edit_ordem['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tecnico_id">Técnico *</label>
                    <select class="form-control" id="tecnico_id" name="tecnico_id" required>
                        <option value="">Selecione um técnico</option>
                        <?php foreach ($tecnicos as $tecnico): ?>
                            <option value="<?php echo $tecnico['id']; ?>" 
                                <?php echo ($edit_ordem && $edit_ordem['tecnico_id'] == $tecnico['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tecnico['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="data_abertura">Data de Abertura *</label>
                    <input type="date" class="form-control" id="data_abertura" name="data_abertura" 
                           value="<?php echo $edit_ordem ? $edit_ordem['data_abertura'] : date('Y-m-d'); ?>" required>
                </div>
                
                <?php if ($edit_ordem): ?>
                <div class="form-group">
                    <label for="data_fechamento">Data de Fechamento</label>
                    <input type="date" class="form-control" id="data_fechamento" name="data_fechamento" 
                           value="<?php echo $edit_ordem ? $edit_ordem['data_fechamento'] : ''; ?>">
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="status">Status *</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Aberta" <?php echo ($edit_ordem && $edit_ordem['status'] == 'Aberta') ? 'selected' : ''; ?>>Aberta</option>
                        <option value="Em andamento" <?php echo ($edit_ordem && $edit_ordem['status'] == 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
                        <option value="Concluido" <?php echo ($edit_ordem && $edit_ordem['status'] == 'Concluido') ? 'selected' : ''; ?>>Concluído</option>
                        <option value="Cancelado" <?php echo ($edit_ordem && $edit_ordem['status'] == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <?php if ($edit_ordem): ?>
                        <button type="submit" name="edit" class="btn btn-save">Salvar Alterações</button>
                        <a href="ordens.php" class="btn btn-primary">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-save">Adicionar Ordem</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Ordens de Serviço</h2>
            <?php if (empty($ordens)): ?>
                <p>Nenhuma ordem de serviço cadastrada.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Técnico</th>
                            <th>Data Abertura</th>
                            <th>Data Fechamento</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordens as $ordem): ?>
                        <tr>
                            <td><?php echo $ordem['id']; ?></td>
                            <td><?php echo htmlspecialchars($ordem['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($ordem['tecnico_nome']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($ordem['data_abertura'])); ?></td>
                            <td><?php echo $ordem['data_fechamento'] ? date('d/m/Y', strtotime($ordem['data_fechamento'])) : '-'; ?></td>
                            <td>
                                <span class="status-<?php echo strtolower(str_replace(' ', '-', $ordem['status'])); ?>">
                                    <?php echo $ordem['status']; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="ordens.php?edit=<?php echo $ordem['id']; ?>" class="btn btn-edit">Editar</a>
                                <a href="ordens.php?delete=<?php echo $ordem['id']; ?>" class="btn btn-delete" 
                                   onclick="return confirm('Tem certeza que deseja excluir esta ordem de serviço?')">Excluir</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
    
    <?php include '../includes/footer.php'; ?>
    <script src="../js/script.js"></script>
</body>
</html>