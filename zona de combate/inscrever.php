<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id_evento'])) {
    $evento_id = intval($_POST['id_evento']);
    $usuario_id = $_SESSION['id_usuario'];

    // Verifica capacidade
    $stmt = $pdo->prepare("SELECT capacidade, (SELECT COUNT(*) FROM inscricoes WHERE evento_id = :eid) as total FROM eventos WHERE id = :eid");
    $stmt->bindValue(':eid', $evento_id);
    $stmt->execute();
    $evento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($evento && $evento['total'] < $evento['capacidade']) {
        try {
            // Tenta inscrever
            $sql = "INSERT INTO inscricoes (evento_id, usuario_id) VALUES (:eid, :uid)";
            $insert = $pdo->prepare($sql);
            $insert->bindValue(':eid', $evento_id);
            $insert->bindValue(':uid', $usuario_id);
            $insert->execute();
        } catch (PDOException $e) {
            // Se já estiver inscrito (erro de chave única), apenas ignora ou redireciona
        }
    }
}

header("Location: eventos.php");
exit;
?>