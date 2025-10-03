<?php
// index.php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WIERZNACKA.INFO - Sistema de Assistência Técnica</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container">
        <div class="welcome-section">
            <h1>Bem-vindo ao WIERZNACKA.INFO</h1>
            <p>Sistema de Gerenciamento de Assistência Técnica</p>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Clientes</h3>
                <p>Gerencie os clientes cadastrados</p>
                <a href="crud/clientes.php" class="btn btn-primary">Acessar</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Equipamentos</h3>
                <p>Controle de equipamentos</p>
                <a href="crud/equipamentos.php" class="btn btn-primary">Acessar</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Técnicos</h3>
                <p>Gerencie a equipe técnica</p>
                <a href="crud/tecnicos.php" class="btn btn-primary">Acessar</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Serviços</h3>
                <p>Catálogo de serviços</p>
                <a href="crud/servicos.php" class="btn btn-primary">Acessar</a>
            </div>
            
            <div class="dashboard-card">
                <h3>Ordens de Serviço</h3>
                <p>Controle de OS</p>
                <a href="crud/ordens.php" class="btn btn-primary">Acessar</a>
            </div>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    <script src="js/script.js"></script>
</body>
</html>