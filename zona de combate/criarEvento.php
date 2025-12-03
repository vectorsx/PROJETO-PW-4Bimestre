<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $sql = "INSERT INTO eventos (titulo, local_evento, data_evento, hora_evento, descricao, capacidade, criador_id) 
                VALUES (:titulo, :local, :data, :hora, :desc, :cap, :criador)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':titulo', $_POST['titulo']);
        $stmt->bindValue(':local', $_POST['local']);
        $stmt->bindValue(':data', $_POST['data']);
        $stmt->bindValue(':hora', $_POST['hora']);
        $stmt->bindValue(':desc', $_POST['descricao']);
        $stmt->bindValue(':cap', $_POST['capacidade']);
        $stmt->bindValue(':criador', $_SESSION['id_usuario']);
        
        $stmt->execute();

        header("Location: eventos.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao criar evento: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Criar Evento</title>
<style>
    body{ background:#0D1414; color:#E0E0E0; font-family:Arial; }
    #janelas{ padding:15px; background:#0F1A1A; border-bottom:1px solid #0a0f0f; }
    #janelas a{ padding:10px 18px; background:#12bea7; border-radius:4px; text-decoration:none; font-weight:bold; color:#0D1414; }
    .container{ max-width:700px; margin:40px auto; background:#111b1b; padding:25px; border-radius:6px; }
    label{ display:block; margin-top:15px; }
    input, textarea{ width:100%; padding:10px; background:#0f1616; color:white; border-radius:4px; border:1px solid #1d2727; }
    button{ width:100%; margin-top:20px; padding:12px; font-size:17px; background:#12bea7; border:none; border-radius:4px; color:#0D1414; font-weight:bold; cursor:pointer; }
</style>
</head>
<body>

<div id="janelas">
    <a href="eventos.php">Voltar</a>
</div>

<div class="container">
    <h1 style="color:#12bea7; text-align:center;">Criar Evento</h1>

    <form method="POST">

        <label>Título do Evento:</label>
        <input type="text" name="titulo" required>

        <label>Local:</label>
        <input type="text" name="local" required>

        <label>Data:</label>
        <input type="date" name="data" required>

        <label>Hora:</label>
        <input type="time" name="hora" required>

        <label>Capacidade Máxima:</label>
        <input type="number" name="capacidade" min="1" required>

        <label>Descrição:</label>
        <textarea name="descricao"></textarea>

        <button type="submit">Criar Evento</button>
    </form>
</div>

</body>
</html>