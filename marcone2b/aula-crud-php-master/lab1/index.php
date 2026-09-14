<?php
require_once 'db.php';

// Variáveis para controlar edição
$id_editar = null;
$nome_editar = '';
$email_editar = '';
$telefone_editar = '';  

// -------------------------------------------------------------
// [C]REATE & [U]PDATE - Processamento do Formulário (POST)
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);

    if (!empty($nome) && !empty($email) && !empty($telefone)) {
        if ($id) {
            // UPDATE: Se o ID existir, atualiza
            $stmt = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id");
            $stmt->execute([':nome' => $nome, ':email' => $email, ':id' => $id, ':telefone' => $telefone]);
        } else {
            // CREATE: Se não houver ID, insere novo registro
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, telefone) VALUES (:nome, :email, :telefone)");
            $stmt->execute([':nome' => $nome, ':email' => $email, ':telefone' => $telefone]);
        }
        header("Location: index.php");
        exit;
    }
}

// -------------------------------------------------------------
// [D]ELETE - Exclusão de Registro (GET)
// -------------------------------------------------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: index.php");
    exit;
}

// -------------------------------------------------------------
// Preparação para Edição (GET)
// -------------------------------------------------------------
if (isset($_GET['edit'])) {
    $id_editar = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $id_editar]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $nome_editar = $usuario['nome'];
        $email_editar = $usuario['email'];
        $telefone_editar = $usuario['telefone'];
    }
}

// -------------------------------------------------------------
// [R]EAD - Buscar todos os usuários cadastrados
// -------------------------------------------------------------
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aula Prática - CRUD em PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; max-width: 400px; }
        form input { display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-del { color: red; text-decoration: none; }
        .btn-edit { color: blue; text-decoration: none; margin-right: 10px; }
    </style>
</head>
<body>

    <h2><?= $id_editar ? 'Editar Usuário' : 'Novo Usuário' ?></h2>

    <!-- FORMULÁRIO (CREATE / UPDATE) -->
    <form action="index.php" method="POST">
        <input type="hidden" name="id" value="<?= $id_editar ?>">
        
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($nome_editar) ?>" required>
        
        <label>E-mail:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email_editar) ?>" required>
        
         <label>Telefone:</label>
        <input type="tel" name="telefone" value="<?= htmlspecialchars($telefone_editar) ?>" required>

        <button type="submit"><?= $id_editar ? 'Atualizar' : 'Cadastrar' ?></button>
        <?php if ($id_editar): ?>
            <a href="index.php">Cancelar</a>
        <?php endif; ?>
    </form>

    <h2>Lista de Usuários (READ)</h2>

    <!-- TABELA (READ / DELETE) -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['nome']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['telefone']) ?></td>
                    <td>
                        <a href="index.php?edit=<?= $user['id'] ?>" class="btn-edit">Editar</a>
                        <a href="index.php?delete=<?= $user['id'] ?>" class="btn-del" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="4">Nenhum usuário cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>