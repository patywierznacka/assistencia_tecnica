<?php
// crud/tecnicos.php
include '../includes/config.php';

// Operações CRUD para técnicos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO tecnico (nome, especialiadade, telefone) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['nome'], $_POST['especialiadade'], $_POST['telefone']]);
        header("Location: tecnicos.php?success=Técnico adicionado com sucesso!");
        exit;
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare("UPDATE tecnico SET nome=?, especialiadade=?, telefone=? WHERE id=?");
        $stmt->execute([$_POST['nome'], $_POST['especialiadade'], $_POST['telefone'], $_POST['id']]);
        header("Location: tecnicos.php?success=Técnico atualizado com sucesso!");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM tecnico WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: tecnicos.php?success=Técnico excluído com sucesso!");
    exit;
}

// Buscar técnico para edição
$edit_tecnico = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM tecnico WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_tecnico = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar técnicos
$stmt = $pdo->query("SELECT * FROM tecnico ORDER BY id DESC");
$tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnicos - WIERZNACKA.INFO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container">
        <h1>Gerenciar Técnicos</h1>
        
        <div class="form-container">
            <h2><?php echo $edit_tecnico ? 'Editar Técnico' : 'Adicionar Novo Técnico'; ?></h2>
            <form method="POST">
                <?php if ($edit_tecnico): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_tecnico['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nome">Nome *</label>
                    <input type="text" class="form-control" id="nome" name="nome" 
                           value="<?php echo $edit_tecnico ? $edit_tecnico['nome'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="especialiadade">Especialidade</label>
                    <input type="text" class="form-control" id="especialiadade" name="especialiadade" 
                           value="<?php echo $edit_tecnico ? $edit_tecnico['especialiadade'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" 
                           value="<?php echo $edit_tecnico ? $edit_tecnico['telefone'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <?php if ($edit_tecnico): ?>
                        <button type="submit" name="edit" class="btn btn-save">Salvar Alterações</button>
                        <a href="tecnicos.php" class="btn btn-primary">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-save">Adicionar Técnico</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Técnicos Cadastrados</h2>
            <?php if (empty($tecnicos)): ?>
                <p>Nenhum técnico cadastrado.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Especialidade</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tecnicos as $tecnico): ?>
                        <tr>
                            <td><?php echo $tecnico['id']; ?></td>
                            <td><?php echo htmlspecialchars($tecnico['nome']); ?></td>
                            <td><?php echo htmlspecialchars($tecnico['especialiadade']); ?></td>
                            <td><?php echo htmlspecialchars($tecnico['telefone']); ?></td>
                            <td class="actions">
                                <a href="tecnicos.php?edit=<?php echo $tecnico['id']; ?>" class="btn btn-edit">Editar</a>
                                <a href="tecnicos.php?delete=<?php echo $tecnico['id']; ?>" class="btn btn-delete" 
                                   onclick="return confirm('Tem certeza que deseja excluir este técnico?')">Excluir</a>
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