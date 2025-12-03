<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {

        $sql = "INSERT INTO usuarios 
                (usuario, senha, nome_completo, data_nascimento, nacionalidade, arte_marcial, peso, sexo, cpf, telefone, endereco) 
                VALUES 
                (:usuario, :senha, :nome, :data_nasc, :nac, :arte, :peso, :sexo, :cpf, :tel, :endereco)";
        
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':usuario', $_POST['usuario']);
        $stmt->bindValue(':senha', password_hash($_POST['senha'], PASSWORD_DEFAULT));
        $stmt->bindValue(':nome', $_POST['nome']);
        $stmt->bindValue(':data_nasc', $_POST['date']);
        $stmt->bindValue(':nac', $_POST['nacionalidade']);
        $stmt->bindValue(':arte', $_POST['artemarcial']);
        $stmt->bindValue(':peso', $_POST['peso']);
        $stmt->bindValue(':sexo', $_POST['sexo']);
        $stmt->bindValue(':cpf', $_POST['cpf']);
        $stmt->bindValue(':tel', $_POST['numero']);
        $stmt->bindValue(':endereco', $_POST['endereco']);

        $stmt->execute();

        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>

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
      padding: 40px 40px;
      border-radius: 14px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
      width: 420px;
      text-align: center;
      border: 1px solid #1d2e2e;
      position: relative;
    }

    .login-container h2 {
      margin-bottom: 18px;
      color: #d4f4f2;
      font-size: 20px;
    }

    .login-container label {
      color: #d4f4f2;
      font-size: 13px;
      text-align: left;
      display: block;
      margin-top: 10px;
    }

    .row {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .row .col {
      flex: 1;
    }

    .full {
      width: 100%;
    }

    input[type="text"],
    input[type="password"],
    input[type="date"],
    input[type="number"],
    input[type="tel"],
    select {
      width: 100%;
      padding: 11px;
      margin: 8px 0;
      border: none;
      border-radius: 8px;
      background: #1c2f2f;
      color: #d4f4f2;
      font-size: 14px;
      outline: none;
      box-sizing: border-box;
    }

    input::placeholder {
      color: #90b3b0;
    }

    input:focus, select:focus {
      box-shadow: 0 0 6px #12bea7;
    }

    .dupla-select {
      display: flex;
      gap: 10px;
      margin-top: 6px;
    }

    .login-container button {
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

    .login-container button:hover {
      background-color: #0fa38f;
    }

    .login-container p {
      margin-top: 12px;
      font-size: 13px;
      color: #a7c8c5;
    }

    .login-container a {
      color: #12bea7;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>

<body>

  <a class="voltar" href="index.php">⟵ Voltar</a>

  <div class="login-container">

    <!-- CORRIGIDO: FORM SEM ACTION -->
    <form method="post" autocomplete="off">

      <input type="text" name="usuario" placeholder="Usuário" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="date" name="date" required>

      <label>Nacionalidade e Arte Marcial:</label>
      <div class="dupla-select">
        <select name="nacionalidade" required>
          <option value="">Nacionalidade</option>
          <option value="br">🇧🇷 Brasil</option>
          <option value="pt">🇵🇹 Portugal</option>
          <option value="us">🇺🇸 Estados Unidos</option>
          <option value="mx">🇲🇽 México</option>
          <option value="de">🇩🇪 Alemanha</option>
          <option value="it">🇮🇹 Itália</option>
          <option value="fr">🇫🇷 França</option>
          <option value="es">🇪🇸 Espanha</option>
          <option value="jp">🇯🇵 Japão</option>
          <option value="kr">🇰🇷 Coreia do Sul</option>
          <option value="cn">🇨🇳 China</option>
          <option value="ru">🇷🇺 Rússia</option>
          <option value="ar">🇦🇷 Argentina</option>
          <option value="co">🇨🇴 Colômbia</option>
          <option value="cl">🇨🇱 Chile</option>
        </select>

        <select name="artemarcial" required>
          <option value="">Arte Marcial</option>
          <option value="jiu-jitsu">Jiu-Jitsu</option>
          <option value="judô">Judô</option>
          <option value="karate">Karate</option>
          <option value="taekwondo">Taekwondo</option>
          <option value="muay-thai">Muay Thai</option>
          <option value="kung-fu">Kung Fu</option>
          <option value="kickboxing">Kickboxing</option>
          <option value="boxe">Boxe</option>
          <option value="krav-maga">Krav Maga</option>
          <option value="mma">MMA</option>
          <option value="capoeira">Capoeira</option>
        </select>
      </div>

      <div class="row" style="margin-top:6px;">
        <div class="col">
          <label>Peso (kg):</label>
          <input type="number" step="0.1" min="0" name="peso" required>
        </div>

        <div class="col">
          <label>Sexo:</label>
          <select name="sexo" required>
            <option value="">Selecione</option>
            <option value="m">Masculino</option>
            <option value="f">Feminino</option>
            <option value="o">Outro</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <label>CPF:</label>
          <input type="text" name="cpf" required>
        </div>

        <div class="col">
          <label>Número:</label>
          <input type="tel" name="numero" maxlength="20" required>
        </div>
      </div>

      <label>Endereço:</label>
      <input type="text" name="endereco" class="full" required>

      <button type="submit">Cadastrar</button>

    </form>

    <?php if(isset($erro)) echo "<p style='color:red'>$erro</p>"; ?>

    <p>Já tem uma conta? <a href="login.php">Logue aqui!</a></p>
  </div>

</body>
</html>
