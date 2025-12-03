<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(["ok" => false, "erro" => "Você não está logado."]);
    exit;
}

if (!isset($_FILES['icone']) || $_FILES['icone']['error'] !== 0) {
    echo json_encode(["ok" => false, "erro" => "Nenhuma imagem enviada."]);
    exit;
}

$arquivo = $_FILES['icone'];
$ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

$permitidas = ["jpg", "jpeg", "png", "webp"];

if (!in_array($ext, $permitidas)) {
    echo json_encode(["ok" => false, "erro" => "Formato inválido. Envie JPG, PNG ou WEBP."]);
    exit;
}

if ($arquivo['size'] > 4 * 1024 * 1024) {
    echo json_encode(["ok" => false, "erro" => "Arquivo muito grande (máx 4MB)."]);
    exit;
}

$caminho = "uploads/";
if (!is_dir($caminho)) {
    mkdir($caminho, 0777, true);
}

$novoNome = "icone_" . session_id() . "." . $ext;
$destino = $caminho . $novoNome;

if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
    $_SESSION['icone'] = $destino;

    echo json_encode([
        "ok" => true,
        "novaFoto" => $destino . "?v=" . time()
    ]);
} else {
    echo json_encode(["ok" => false, "erro" => "Erro ao salvar imagem."]);
}
