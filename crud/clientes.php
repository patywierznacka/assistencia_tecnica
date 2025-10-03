<?php
// crud/clientes.php
include '../includes/config.php';

// Operações CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Adicionar cliente
        $stmt = $pdo->prepare("INSERT INTO cliente (nome, telefone, email, enereco) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['enereco']]);
        header("Location: clientes.php?success=Cliente adicionado com sucesso!");
        exit;
    } elseif (isset($_POST['edit'])) {
        // Editar cliente
        $stmt = $pdo->prepare("UPDATE cliente SET nome=?, telefone=?, email=?, enereco=? WHERE id=?");
        $stmt->execute([$_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['enereco'], $_POST['id']]);
        header("Location: clientes.php?success=Cliente atualizado com sucesso!");
        exit;
    }
}

if (isset($_GET['delete'])) {
    // Excluir cliente
    $stmt = $pdo->prepare("DELETE FROM cliente WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    header("Location: clientes.php?success=Cliente excluído com sucesso!");
    exit;
}

// Buscar cliente para edição
$edit_cliente = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM cliente WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $edit_cliente = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Listar clientes
$stmt = $pdo->query("SELECT * FROM cliente ORDER BY id DESC");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - WIERZNACKA.INFO</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    
    <main class="container">
        <h1>Gerenciar Clientes</h1>
        
        <!-- Formulário de Cliente -->
        <div class="form-container">
            <h2><?php echo $edit_cliente ? 'Editar Cliente' : 'Adicionar Novo Cliente'; ?></h2>
            <form method="POST">
                <?php if ($edit_cliente): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_cliente['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nome">Nome *</label>
                    <input type="text" class="form-control" id="nome" name="nome" 
                           value="<?php echo $edit_cliente ? $edit_cliente['nome'] : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" 
                           value="<?php echo $edit_cliente ? $edit_cliente['telefone'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?php echo $edit_cliente ? $edit_cliente['email'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="enereco">Endereço</label>
                    <input type="text" class="form-control" id="enereco" name="enereco" 
                           value="<?php echo $edit_cliente ? $edit_cliente['enereco'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <?php if ($edit_cliente): ?>
                        <button type="submit" name="edit" class="btn btn-save">Salvar Alterações</button>
                        <a href="clientes.php" class="btn btn-primary">Cancelar</a>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-save">Adicionar Cliente</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Lista de Clientes -->
        <div class="table-container">
            <h2>Clientes Cadastrados</h2>
            <?php if (empty($clientes)): ?>
                <p>Nenhum cliente cadastrado.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['id']; ?></td>
                            <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['enereco']); ?></td>
                            <td class="actions">
                                <a href="clientes.php?edit=<?php echo $cliente['id']; ?>" class="btn btn-edit">Editar</a>
                                <a href="clientes.php?delete=<?php echo $cliente['id']; ?>" class="btn btn-delete" 
                                   onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
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