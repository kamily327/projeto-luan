<?php
require_once('./conexao.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
$id_usuario = $_SESSION['usuario_id'];

$stmt = $conn->prepare("
    SELECT i.*, e.local_evento, e.data_evento, e.preco_base 
    FROM ingressos i
    JOIN eventos e ON i.evento_id = e.id
    WHERE i.usuario_id = :usuario_id
    ORDER BY i.data_compra DESC
");
$stmt->execute([':usuario_id' => $id_usuario]);
$ingressos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Ingressos - Luan Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'pure-black': '#000000', 'luan-gold': '#D4AF37' } } } }
    </script>
</head>
<body class="bg-pure-black text-white min-h-screen px-6 py-12">

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-white/10 pb-8 mb-8 gap-4">
            <div>
                <span class="text-xs text-luan-gold font-black uppercase tracking-widest">Área do Cliente</span>
                <h1 class="text-4xl font-black uppercase tracking-tighter mt-1">Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
                <p class="text-gray-400 text-sm mt-1">Aqui estão seus ingressos salvos para a Tour Registro Histórico.</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="index.php" class="py-3 px-6 bg-white/5 border border-white/10 text-white font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white/10 transition duration-300">
                    Ver Shows
                </a>
                <a href="logout.php" class="py-3 px-6 bg-red-500/10 border border-red-500/20 text-red-400 font-black uppercase text-xs tracking-widest rounded-xl hover:bg-red-500/20 transition duration-300">
                    Sair
                </a>
            </div>
        </div>

        <?php if (empty($ingressos)): ?>
            <div class="text-center py-16 bg-gray-900/20 border border-white/5 rounded-3xl backdrop-blur-xl">
                <p class="text-gray-400 text-sm mb-6">Você ainda não garantiu nenhum ingresso para esta tour.</p>
                <a href="index.php" class="inline-block py-4 px-8 bg-luan-gold text-black font-black uppercase text-xs tracking-widest rounded-xl hover:bg-white transition duration-500">
                    Garantir Meu Primeiro Ingresso
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($ingressos as $ingresso): 
                    $data_show = new DateTime($ingresso['data_evento']);
                ?>
                    <div class="bg-gray-900/40 border border-white/5 p-6 rounded-3xl backdrop-blur-xl flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-luan-gold bg-luan-gold/10 px-3 py-1 rounded-full">
                                    Ingresso #<?php echo $ingresso['id']; ?>
                                </span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-green-400 bg-green-400/10 px-3 py-1 rounded-full">
                                    <?php echo $ingresso['status_pagamento']; ?>
                                </span>
                            </div>

                            <h3 class="text-xl font-black uppercase italic tracking-tight text-white mb-1">
                                <?php echo htmlspecialchars($ingresso['local_evento']); ?>
                            </h3>
                            <p class="text-gray-400 text-xs mb-4">
                                Data do Show: <span class="text-white font-medium"><?php echo $data_show->format('d/m/Y H:i'); ?></span>
                            </p>

                            <div class="space-y-1 bg-black/40 p-4 rounded-2xl text-xs mb-6 border border-white/5">
                                <p><span class="text-gray-500 font-bold uppercase">Setor:</span> <?php echo htmlspecialchars($ingresso['setor_escolhido']); ?></p>
                                <p><span class="text-gray-500 font-bold uppercase">Total Pago:</span> <span class="text-white font-bold">R$ <?php echo number_format($ingresso['valor_pago'], 2, ',', '.'); ?></span></p>
                            </div>
                        </div>

                        <a href="gerar_comprovante.php?ingresso_id=<?php echo $ingresso['id']; ?>" target="_blank" class="w-full text-center py-4 bg-white/5 border border-white/10 text-white font-black uppercase text-[10px] tracking-widest rounded-xl hover:bg-luan-gold hover:text-black transition-all duration-500">
                            Baixar PDF / QR Code
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>