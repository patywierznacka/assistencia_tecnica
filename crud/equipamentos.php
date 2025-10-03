<?php
// crud/equipamentos.php
include '../includes/config.php';

// Operações CRUD para equipamentos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO equipamento (cliente_id, tipo, marca, modelo, numero_serie) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['cliente_id'], $_POST['tipo'], $_POST['marca'], $_POST['modelo'], $_POST['numero_serie']]);
        header("Location: equipamentos.php?success=Equipamento adicionado com sucesso!");
        exit;
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE equipamento SET cliente_id=?, tipo=?, marca=?, modelo=?, numero_serie=? WHERE id=?");
        $stmt->execute([$_POST['cliente_id'], $_POST['tipo'], $_POST['marca'], $_POST['modelo'], $_POST['numero_serie'], $_POST['id']]);
        header("Location: equipamentos.php?success=Equipamento atualizado com sucesso!");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM equipamento WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: equipamentos.php?success=Equipamento excluído com sucesso!");
    exit;
}

// Buscar equipamento para edição
$edit_equipamento = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM equipamento WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_equipamento = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar equipamentos com informações do cliente
$stmt = $pdo->query("
    SELECT e.*, c.nome as cliente_nome 
    FROM equipamento e 
    LEFT JOIN cliente c ON e.cliente_id = c.id 
    ORDER BY e.id DESC
");
$equipamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar clientes para o select
$stmt_clientes = $pdo->query("SELECT id, nome FROM cliente ORDER BY nome");
$clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos - WIERZNACKA.INFO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container">
        <h1>Gerenciar Equipamentos</h1>
        
        <div class="form-container">
            <h2><?php echo $edit_equipamento ? 'Editar Equipamento' : 'Adicionar Novo Equipamento'; ?></h2>
            <form method="POST">
                <?php if ($edit_equipamento): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_equipamento['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="cliente_id">Cliente *</label>
                    <select class="form-control" id="cliente_id" name="cliente_id" required>
                        <option value="">Selecione um cliente</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>" 
                                <?php echo ($edit_equipamento && $edit_equipamento['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="tipo">Tipo *</label>
                    <input type="text" class="form-control" id="tipo" name="tipo" 
                           value="<?php echo $edit_equipamento ? $edit_equipamento['tipo'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" 
                           value="<?php echo $edit_equipamento ? $edit_equipamento['marca'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" 
                           value="<?php echo $edit_equipamento ? $edit_equipamento['modelo'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="numero_serie">Número de Série</label>
                    <input type="text" class="form-control" id="numero_serie" name="numero_serie" 
                           value="<?php echo $edit_equipamento ? $edit_equipamento['numero_serie'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <?php if ($edit_equipamento): ?>
                        <button type="submit" name="edit" class="btn btn-save">Salvar Alterações</button>
                        <a href="equipamentos.php" class="btn btn-primary">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-save">Adicionar Equipamento</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Equipamentos Cadastrados</h2>
            <?php if (empty($equipamentos)): ?>
                <p>Nenhum equipamento cadastrado.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Nº Série</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($equipamentos as $equipamento): ?>
                        <tr>
                            <td><?php echo $equipamento['id']; ?></td>
                            <td><?php echo htmlspecialchars($equipamento['cliente_nome']); ?></td>
                            <td><?php echo htmlspecialchars($equipamento['tipo']); ?></td>
                            <td><?php echo htmlspecialchars($equipamento['marca']); ?></td>
                            <td><?php echo htmlspecialchars($equipamento['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($equipamento['numero_serie']); ?></td>
                            <td class="actions">
                                <a href="equipamentos.php?edit=<?php echo $equipamento['id']; ?>" class="btn btn-edit">Editar</a>
                                <a href="equipamentos.php?delete=<?php echo $equipamento['id']; ?>" class="btn btn-delete" 
                                   onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">Excluir</a>
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