<?php 
session_start();
// O ícone agora vem da sessão preenchida no login.php
$iconeUsuario = isset($_SESSION['icone']) ? $_SESSION['icone'] : 'images/account_2486717.png';
$logado = isset($_SESSION['logado']) && $_SESSION['logado'] === true;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Zona de Combate</title>
  <style>
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: #0D1414;
      font-family: Arial, sans-serif;
      color: #E0E0E0;
    }

    /* Barra superior */
    #janelas {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px 20px;
      background-color: #0F1A1A;
      border-bottom: 1px solid #0a0f0f;
    }

    #janelas a {
      background-color: #12bea7;
      padding: 10px 18px;
      border-radius: 4px;
      text-decoration: none;
      color: #0D1414;
      font-weight: bold;
      cursor: pointer;
      transition: 0.2s;
    }

    #janelas a:hover {
      background-color: #0fae99;
    }

    #janelas a.d {
      margin-left: auto;
    }

    /* Avatar */
    .avatar {
      border-radius: 50%;
      background-color: #ffffff;
      cursor: pointer;
      transition: 0.15s;
    }

    .avatar:hover {
      transform: scale(1.05);
    }

    /* Menu do perfil */
    #perfilMenu {
      position: absolute;
      top: 70px;
      right: 20px;
      background-color: #131919;
      border: 1px solid #1f2b2b;
      border-radius: 6px;
      width: 230px;
      padding: 12px;
      display: none;
    }

    #perfilMenu h3 {
      text-align: center;
      color: #12bea7;
      margin-bottom: 10px;
      font-size: 1.05em;
    }

    #perfilMenu button {
      width: 100%;
      background-color: #12bea7;
      border: none;
      padding: 8px;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
      color: #0D1414;
      margin-top: 8px;
    }

    #perfilMenu button:hover {
      background-color: #0fae99;
    }

    /* Fundo dinâmico */
    #bg {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-size: cover;
      background-position: center;
      filter: brightness(0.55);
      z-index: -1;
    }

    /* Texto principal */
    #textoApresentacao {
      width: 70%;
      max-width: 850px;
      margin: 60px auto;
      padding: 35px;
      background: rgba(0,0,0,0.55);
      border: 1px solid #1a1f1f;
      border-radius: 8px;
    }

    #textoApresentacao h1 {
      color: #12bea7;
      margin-bottom: 15px;
      text-align: center;
    }

    #textoApresentacao p {
      font-size: 1.05em;
      line-height: 1.55em;
      margin-bottom: 12px;
    }

    /* Seções */
    section {
      height: 85vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    iframe {
      position: relative;
      z-index: 10;
    }
  </style>
</head>
<body>

  <div id="janelas">
    <a onclick="window.location.href='eventos.php'">Eventos</a>
    <a onclick="window.open('https://lista.mercadolivre.com.br/luta#D[A:luta].php', '_blank')">Loja</a>


    <img 
      class="avatar" 
      src="<?php echo $iconeUsuario; ?>?v=<?php echo time(); ?>" 
      width="50" height="45" 
      id="avatarBtn">
  </div>

  <div id="perfilMenu">
    <h3>Zona de Combate</h3>
    <button onclick="editarIcone()">Editar ícone do lutador</button>
    <button onclick="editarBio()">Editar bio do lutador</button>
  </div>

  <div id="bg"></div>

  <div id="textoApresentacao">
    <h1>Zona de Combate</h1>
    <p>
      Cansado de ficar fazendo nada em casa? Conquiste a glória dos eventos de lutas! Aqui você pode
      fazer eventos de qualquer categoria, onde bem entender — seja no quintal de casa, 
      na suíte do seu hotel, em um campo de rosas, onde quiser.
    </p>
    <p>
      Monte sua equipe, treine seus lutadores e construa sua própria reputação.
    </p>
  </div>

  <section id="sec1"></section>
  <section id="sec2"></section>
  <section id="sec3">
    <iframe src="boxels.html" width="620" height="560" style="border: none;"></iframe>
  </section>

<script>
const logado = <?php echo $logado ? 'true' : 'false'; ?>;

function acessarRestrito(pagina) {
  if (!logado) {
    window.location.href = 'login.php';
  } else {
    window.location.href = pagina;
  }
}

const avatarBtn = document.getElementById('avatarBtn');
const perfilMenu = document.getElementById('perfilMenu');

avatarBtn.addEventListener('click', () => {
  if (!logado) {
    window.location.href = 'login.php';
    return;
  }
  perfilMenu.style.display = perfilMenu.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', (e) => {
  if (!perfilMenu.contains(e.target) && !avatarBtn.contains(e.target)) {
    perfilMenu.style.display = 'none';
  }
});

function editarIcone() {
  const input = document.createElement("input");
  input.type = "file";
  input.accept = "image/*";

  input.onchange = () => {
      const form = new FormData();
      form.append("icone", input.files[0]);

      // Você não enviou o uploadIcone.php, mas ele deve salvar o caminho da imagem no banco de dados
      // e atualizar o $_SESSION['icone']
      fetch("uploadIcone.php", {
          method: "POST",
          body: form
      })
      .then(r => r.json())
      .then(res => {
          if (res.ok) {
              document.getElementById('avatarBtn').src = res.novaFoto + "?v=" + Date.now();
          } else {
              alert(res.erro);
          }
      })
      .catch(() => alert("Erro ao enviar imagem."));
  };

  input.click();
}

// Fundo dinâmico
const bg = document.getElementById('bg');
const sections = document.querySelectorAll('section');
const images = [
  'images/baguiu.jpeg',
  'images/anderson silva.webp',
  'images/roger gracie.jpg'
];

// Corrigido para carregar a primeira imagem corretamente no início
bg.style.backgroundImage = `url('${images[0]}')`;

window.addEventListener('scroll', () => {
  const scrollPos = window.scrollY;
  const windowHeight = window.innerHeight;

  sections.forEach((section, i) => {
    const offsetTop = section.offsetTop;
    if (scrollPos >= offsetTop - windowHeight / 2 && scrollPos < offsetTop + section.offsetHeight) {
      if(images[i]) bg.style.backgroundImage = `url('${images[i]}')`;
    }
  });
});
</script>

</body>
</html>