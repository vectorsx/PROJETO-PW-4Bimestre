<?php
session_start();
require 'conexao.php';
$logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;

// Busca eventos e conta inscritos
$sql = "SELECT e.*, 
       (SELECT COUNT(*) FROM inscricoes WHERE evento_id = e.id) as total_inscritos
       FROM eventos e ORDER BY e.data_evento DESC";
$stmt = $pdo->query($sql);
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Eventos</title>
<style>
    body{ background:#0D1414; color:#E0E0E0; font-family:Arial; }
    #janelas{ display:flex; gap:15px; padding:15px 20px; background:#0F1A1A; border-bottom:1px solid #0a0f0f; }
    #janelas a{ background:#12bea7; padding:10px 18px; border-radius:4px; font-weight:bold; color:#0D1414; text-decoration:none; cursor:pointer; }
    .container{ max-width:900px; margin:30px auto; padding:15px; }
    .evento-box{ background:#111b1b; padding:18px; border-radius:6px; border:1px solid #0f1a1a; margin-bottom:15px; }
    .evento-box h2{ color:#12bea7; font-size:22px; }
</style>
</head>
<body>

<div id="janelas">
    <a onclick="acessarRestrito('criarEvento.php')">Criar Evento</a>
    <a href="index.php">Voltar</a>
</div>

<div class="container">
    <h1 style="color:#12bea7; text-align:center;">Eventos</h1>

    <?php if (count($eventos) > 0): ?>
        <?php foreach ($eventos as $evento): ?>
<div class="evento-box">
    <h2><?= htmlspecialchars($evento['titulo']); ?></h2>

    <p><strong>Local:</strong> <?= htmlspecialchars($evento['local_evento']); ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($evento['data_evento'])); ?></p>
    <p><strong>Hora:</strong> <?= htmlspecialchars($evento['hora_evento']); ?></p>
    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($evento['descricao'])); ?></p>

    <p><strong>Inscritos:</strong> <?= $evento['total_inscritos']; ?>/<?= $evento['capacidade']; ?></p>

    <?php if ($evento['total_inscritos'] < $evento['capacidade']): ?>
        <form action="inscrever.php" method="POST" style="display:inline;">
            <input type="hidden" name="id_evento" value="<?= $evento['id'] ?>">
            <button style="
                margin-top:10px;
                padding:10px 15px;
                background:#12bea7;
                color:#0D1414;
                border:none;
                border-radius:4px;
                cursor:pointer;
                font-weight:bold;
            ">Entrar no Evento</button>
        </form>
    <?php else: ?>
        <p style="color:#ff6b6b; font-weight:bold;">Evento Lotado</p>
    <?php endif; ?>

    <form action="verInscritos.php" method="POST" style="display:inline;">
        <input type="hidden" name="id_evento" value="<?= $evento['id'] ?>">
        <button style="
            margin-top:10px;
            padding:10px 15px;
            background:#2aa0ff;
            color:white;
            border:none;
            border-radius:4px;
            cursor:pointer;
            font-weight:bold;
        ">Ver Inscritos</button>
    </form>

</div>
<?php endforeach; ?>

    <?php else: ?>
        <p style="text-align:center; opacity:0.6;">Nenhum evento criado ainda...</p>
    <?php endif; ?>
</div>

<script>
const logado = <?= $logado ? 'true' : 'false' ?>;

function acessarRestrito(pagina){
    if(!logado){ window.location.href='login.php'; }
    else{ window.location.href=pagina; }
}
</script>

</body>
</html>