<?php
require_once('./conexao.php');
session_start();

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $nivel_acesso = 'cliente'; 

    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
           
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (:nome, :email, :senha, :nivel_acesso)");
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senha_hash,
                ':nivel_acesso' => $nivel_acesso
            ]);

            $_SESSION['usuario_id'] = $conn->lastInsertId();
            $_SESSION['usuario_nome'] = $nome;

            if (isset($_SESSION['checkout_evento_id'])) {
                $id_evento = $_SESSION['checkout_evento_id'];
                unset($_SESSION['checkout_evento_id']);
                header("Location: comprar.php?id=" . $id_evento);
            } else {
                header("Location: index.php");
            }
            exit;

        } catch (PDOException $e) {
            $erro = "Este e-mail já está cadastrado.";
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
    <title>Cadastro - Luan Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'pure-black': '#000000', 'luan-gold': '#D4AF37' } } } }
    </script>
</head>
<body class="bg-pure-black text-white flex items-center justify-center min-h-screen px-6">

    <div class="w-full max-w-md bg-gray-900/40 border border-white/5 p-8 rounded-3xl backdrop-blur-xl">
        <h2 class="text-3xl font-black text-center text-luan-gold mb-2 uppercase tracking-tighter">Criar Conta</h2>
        <p class="text-gray-400 text-center text-xs mb-6 uppercase tracking-widest">Para garantir seu ingresso</p>

        <?php if (!empty($erro)): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs p-3 rounded-xl mb-4 text-center font-bold">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form action="cadastro.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Nome Completo</label>
                <input type="text" name="nome" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">E-mail</label>
                <input type="email" name="email" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Senha</label>
                <input type="password" name="senha" required class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition">
            </div>

            <button type="submit" class="w-full py-4 bg-luan-gold text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white transition duration-500 mt-2">
                Cadastrar e Continuar
            </button>
        </form>

        <p class="text-gray-400 text-xs text-center mt-6">
            Já tem uma conta? <a href="login.php" class="text-luan-gold hover:underline">Faça login</a>
        </p>
    </div>

</body>
</html>