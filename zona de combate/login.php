<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = $_POST['usuario'];
  $senha   = $_POST['senha'];

  $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':usuario', $usuario);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['logado'] = true;
    $_SESSION['id_usuario'] = $user['id'];
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['icone'] = $user['icone']; // Pega do banco
    header("Location: index.php");
    exit;
  } else {
    $erro = "Usuário ou senha incorretos.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #0F1A1A;
      height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .voltar {
      position: absolute;
      top: 25px;
      left: 25px;
      color: #12bea7;
      font-weight: 600;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 6px;
      transition: 0.3s;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid #1d2e2e;
    }
    .voltar:hover {
      background: #12bea7;
      color: #0f1a1a;
      border-color: #12bea7;
    }

    .login-container {
      background-color: #101f1f;
      padding: 40px;
      border-radius: 14px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
      width: 360px;
      text-align: center;
      border: 1px solid #1d2e2e;
    }

    .login-container h2 {
      margin-bottom: 18px;
      color: #d4f4f2;
      font-size: 22px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 11px;
      margin: 8px 0;
      border: none;
      border-radius: 8px;
      background: #1c2f2f;
      color: #d4f4f2;
      font-size: 14px;
      outline: none;
      transition: 0.18s;
      box-sizing: border-box;
    }

    input[type="text"]::placeholder,
    input[type="password"]::placeholder {
      color: #90b3b0;
    }

    input:focus {
      box-shadow: 0 0 6px #12bea7;
    }

    button {
      width: 100%;
      background-color: #12bea7;
      color: #0f1a1a;
      border: none;
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: 0.25s;
      margin-top: 8px;
    }

    button:hover {
      background-color: #0fa38f;
    }

    p {
      margin-top: 12px;
      font-size: 13px;
      color: #a7c8c5;
    }

    a {
      color: #12bea7;
      text-decoration: none;
      font-weight: 600;
    }

    .erro {
      color: #ff7777;
      font-size: 13px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <a class="voltar" href="index.php">⟵ Voltar</a>

  <div class="login-container">
    <h2>Login</h2>
    <form action="" method="post" autocomplete="off">
      <input type="text" name="usuario" placeholder="Usuário" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>

    <?php if (!empty($erro)) echo "<p class='erro'>$erro</p>"; ?>

    <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
  </div>

</body>
</html>