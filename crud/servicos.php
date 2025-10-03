<?php
// crud/servicos.php
include '../includes/config.php';

// Operações CRUD para serviços
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO servico (descricao, valor) VALUES (?, ?)");
        $stmt->execute([$_POST['descricao'], $_POST['valor']]);
        header("Location: servicos.php?success=Serviço adicionado com sucesso!");
        exit;
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE servico SET descricao=?, valor=? WHERE id=?");
        $stmt->execute([$_POST['descricao'], $_POST['valor'], $_POST['id']]);
        header("Location: servicos.php?success=Serviço atualizado com sucesso!");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM servico WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: servicos.php?success=Serviço excluído com sucesso!");
    exit;
}

// Buscar serviço para edição
$edit_servico = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM servico WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_servico = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar serviços
$stmt = $pdo->query("SELECT * FROM servico ORDER BY id DESC");
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - WIERZNACKA.INFO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container">
        <h1>Gerenciar Serviços</h1>
        
        <div class="form-container">
            <h2><?php echo $edit_servico ? 'Editar Serviço' : 'Adicionar Novo Serviço'; ?></h2>
            <form method="POST">
                <?php if ($edit_servico): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_servico['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="descricao">Descrição *</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" 
                           value="<?php echo $edit_servico ? $edit_servico['descricao'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="valor">Valor *</label>
                    <input type="number" step="0.01" class="form-control" id="valor" name="valor" 
                           value="<?php echo $edit_servico ? $edit_servico['valor'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <?php if ($edit_servico): ?>
                        <button type="submit" name="edit" class="btn btn-save">Salvar Alterações</button>
                        <a href="servicos.php" class="btn btn-primary">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-save">Adicionar Serviço</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Serviços Cadastrados</h2>
            <?php if (empty($servicos)): ?>
                <p>Nenhum serviço cadastrado.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Valor (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($servicos as $servico): ?>
                        <tr>
                            <td><?php echo $servico['id']; ?></td>
                            <td><?php echo htmlspecialchars($servico['descricao']); ?></td>
                            <td>R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?></td>
                            <td class="actions">
                                <a href="servicos.php?edit=<?php echo $servico['id']; ?>" class="btn btn-edit">Editar</a>
                                <a href="servicos.php?delete=<?php echo $servico['id']; ?>" class="btn btn-delete" 
                                   onclick="return confirm('Tem certeza que deseja excluir este serviço?')">Excluir</a>
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