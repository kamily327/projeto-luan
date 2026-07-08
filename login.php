<?php
require_once('./conexao.php');
session_start();

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (!empty($email) && !empty($senha)) {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];


            if (isset($_SESSION['checkout_evento_id'])) {
                $id_evento = $_SESSION['checkout_evento_id'];
                unset($_SESSION['checkout_evento_id']);
                header("Location: comprar.php?id=" . $id_evento);
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Luan Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pure-black': '#000000',
                        'luan-gold': '#D4AF37'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-pure-black text-white flex items-center justify-center min-h-screen px-6">

    <div class="w-full max-w-md bg-gray-900/40 border border-white/5 p-8 rounded-3xl backdrop-blur-xl">
        <h2 class="text-3xl font-black text-center text-luan-gold mb-2 uppercase tracking-tighter">Entrar</h2>
        <p class="text-gray-400 text-center text-xs mb-6 uppercase tracking-widest">Acesse sua conta para continuar</p>

        <?php if (!empty($erro)): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs p-3 rounded-xl mb-4 text-center font-bold">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">E-mail</label>
                <input type="email" name="email" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Senha</label>
                <input type="password" name="senha" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition">
            </div>

            <button type="submit" class="w-full py-4 bg-luan-gold text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white transition duration-500 mt-2">
                Entrar
            </button>
        </form>

        <p class="text-gray-400 text-xs text-center mt-6">
            Não tem uma conta? <a href="cadastro.php" class="text-luan-gold hover:underline">Cadastre-se</a>
        </p>
    </div>

</body>

</html>