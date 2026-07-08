<?php
require_once('./conexao.php');
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
$id_evento = $_GET['id'];
$id_usuario = $_SESSION['usuario_id'];
$sucesso = false;
$erro = "";
$stmt = $conn->prepare("SELECT * FROM eventos WHERE id = :id");
$stmt->execute([':id' => $id_evento]);
$evento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$evento) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setor_escolhido'])) {
    $setor = $_POST['setor_escolhido'];
    
    $preco_unitario = $evento['preco_base'];
    if ($setor === 'Camarote') {
        $preco_unitario += 150.00;
    }

    $valor_pago = $preco_unitario;
    $status_pagamento = 'Aprovado';

    try {
        $stmt = $conn->prepare("INSERT INTO ingressos (usuario_id, evento_id, setor_escolhido, valor_pago, status_pagamento) VALUES (:usuario_id, :evento_id, :setor_escolhido, :valor_pago, :status_pagamento)");
        
        $stmt->execute([
            ':usuario_id' => $id_usuario,
            ':evento_id' => $id_evento,
            ':setor_escolhido' => $setor,
            ':valor_pago' => $valor_pago,
            ':status_pagamento' => $status_pagamento
        ]);

        $ultimo_id_ingresso = $conn->lastInsertId();

        $sucesso = true;
    } catch (PDOException $e) {
        $erro = "Erro ao processar sua compra no banco de dados. Tente novamente.";
    }
} 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Luan Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'pure-black': '#000000', 'luan-gold': '#D4AF37' } } } }
    </script>
</head>
<body class="bg-pure-black text-white flex items-center justify-center min-h-screen px-6">

    <div class="w-full max-w-md bg-gray-900/40 border border-white/5 p-8 rounded-3xl backdrop-blur-xl">
        
        <?php if ($sucesso): ?>

            <div class="text-center py-6">
                <div class="w-16 h-16 bg-luan-gold/10 text-luan-gold rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">✓</div>
                <h2 class="text-2xl font-black text-luan-gold mb-2 uppercase tracking-tighter">Compra Confirmada!</h2>
                <p class="text-gray-400 text-sm mb-6">Parabéns, <?php echo $_SESSION['usuario_nome']; ?>! Seu ingresso para o show em <span class="text-white font-bold"><?php echo $evento['local_evento']; ?></span> foi garantido com sucesso.</p>
                
                <div class="bg-black/50 border border-white/5 rounded-2xl p-4 mb-6 text-left text-xs space-y-1">
                    <p><span class="text-gray-500 font-bold uppercase">Setor:</span> <?php echo $setor; ?></p>
                    <p><span class="text-gray-500 font-bold uppercase">Status:</span> <span class="text-green-400 font-bold"><?php echo $status_pagamento; ?></span></p>
                </div>

                <div class="space-y-3">
                    <a href="gerar_comprovante.php?ingresso_id=<?php echo $ultimo_id_ingresso; ?>" target="_blank" class="block w-full py-4 bg-luan-gold text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white transition duration-500 shadow-lg shadow-luan-gold/20">
                        Baixar Ingressos (PDF)
                    </a>
                    <a href="index.php" class="block w-full py-4 bg-white/5 border border-white/10 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white/10 transition duration-500">
                        Voltar para a Home
                    </a>
                </div>
            </div>

        <?php else: ?>
            <h2 class="text-3xl font-black text-center text-luan-gold mb-2 uppercase tracking-tighter">Checkout</h2>
            <p class="text-gray-400 text-center text-xs mb-6 uppercase tracking-widest">Confirme seus dados para o show</p>

            <?php if (!empty($erro)): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs p-3 rounded-xl mb-4 text-center font-bold">
                    <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <div class="border-b border-white/10 pb-4 mb-4">
                <span class="text-[10px] text-luan-gold font-bold uppercase tracking-widest">Evento</span>
                <h3 class="text-xl font-black text-white uppercase italic mt-1"><?php echo $evento['local_evento']; ?></h3>
                <p class="text-gray-400 text-xs mt-1">Preço Base (Pista): <span class="text-white font-bold">R$ <?php echo number_format($evento['preco_base'], 2, ',', '.'); ?></span></p>
            </div>

            <form action="comprar.php?id=<?php echo $id_evento; ?>" method="POST" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Comprador</label>
                    <input type="text" disabled value="<?php echo $_SESSION['usuario_nome']; ?>" class="w-full bg-black/30 border border-white/5 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed font-medium">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Escolha o Setor</label>
                    <select name="setor_escolhido" id="setor_escolhido" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-luan-gold focus:outline-none transition font-medium">
                        <option value="Pista">Pista (R$ <?php echo number_format($evento['preco_base'], 2, ',', '.'); ?>)</option>
                        <option value="Camarote">Camarote (R$ <?php echo number_format($evento['preco_base'] + 150.00, 2, ',', '.'); ?>)</option>
                    </select>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-luan-gold text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white transition duration-500 shadow-lg shadow-luan-gold/20">
                        Finalizar e Pagar
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>