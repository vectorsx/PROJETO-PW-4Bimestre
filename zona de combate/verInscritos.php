<?php
session_start();
require 'conexao.php';

if (!isset($_POST['id_evento'])) {
    header("Location: eventos.php");
    exit;
}

$evento_id = intval($_POST['id_evento']);

// Pega informações do evento
$stmt = $pdo->prepare("SELECT titulo FROM eventos WHERE id = ?");
$stmt->execute([$evento_id]);
$evento = $stmt->fetch(PDO::FETCH_ASSOC);

// Pega lista de inscritos
$sql = "SELECT u.usuario FROM inscricoes i 
        JOIN usuarios u ON i.usuario_id = u.id 
        WHERE i.evento_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$evento_id]);
$inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Inscritos</title>
<style>
    body{ background:#0D1414; color:white; font-family:Arial; }
    .box{ max-width:600px; margin:40px auto; padding:20px; background:#111b1b; border-radius:6px; }
    a{ background:#12bea7; padding:10px 18px; border-radius:4px; color:#0D1414; text-decoration:none; font-weight:bold; }
</style>
</head>
<body>

<div class="box">
    <h2 style="color:#12bea7;">Inscritos em: <?= htmlspecialchars($evento['titulo'] ?? 'Evento') ?></h2>

    <?php if (count($inscritos) == 0): ?>
        <p>Ninguém entrou no evento ainda.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($inscritos as $pessoa): ?>
                <li><?= htmlspecialchars($pessoa['usuario']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <br>
    <a href="eventos.php">Voltar</a>
</div>

</body>
</html>