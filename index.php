<?php
session_start();
require_once('./conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luan Santana - Tour 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @font-face {
            font-family: 'BigNoodleTitling';
            src: url('./src/assets/fonts/big_noodle_titling.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pure-black': '#000000',
                        'luan-gold': '#D4AF37',
                    },
                    fontFamily: {
                        'noodle': ['BigNoodleTitling', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-pure-black text-white overflow-x-hidden">

    <header class="md:fixed md:w-full md:z-50 md:bg-pure-black/60 md:backdrop-blur-xl md:border-b md:border-white/5 bg-transparent">

        <nav class="hidden p-3 md:max-w-7xl md:mx-auto md:px-6 md:py-4 md:flex md:justify-between md:items-center md:relative">

            <div class="text-luan-gold font-black md:text-2xl tracking-tighter text-center text-3xl">
                LUAN <span class="text-white">SANTANA</span>
            </div>

            <div class="hidden md:flex space-x-10 text-[11px] font-bold uppercase tracking-[0.2rem] text-gray-400">
                <a href="#" class="hover:text-luan-gold transition">Início</a>
                <a href="#shows" class="hover:text-luan-gold transition">A Tour</a>
                <a href="#shows" class="hover:text-luan-gold transition">Cidades</a>
                <a href="#contact" class="hover:text-luan-gold transition">Contato</a>
            </div>

            <div class="hidden md:flex items-center space-x-6">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-gray-500">
                        Olá, <span class="text-luan-gold font-black"><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></span>
                    </span>

                    <a href="meus_ingressos.php" class="text-[12px] font-bold uppercase tracking-widest text-white hover:text-luan-gold transition">
                        Meus Ingressos
                    </a>

                    <a href="logout.php" class="text-[12px] font-bold uppercase tracking-widest text-red-400 hover:text-red-500 transition">
                        Sair
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-[12px] font-bold uppercase tracking-widest text-white hover:text-luan-gold transition">
                        Entrar
                    </a>

                    <a href="#shows" class="bg-luan-gold text-black text-[10px] font-black uppercase tracking-widest px-8 py-3 rounded-full hover:bg-white transition-all duration-500 text-center">
                        Comprar Ingresso
                    </a>
                <?php endif; ?>
            </div>

        </nav>
    </header>


    <div id="menuToggle" class="md:hidden fixed bottom-0 left-0 w-full z-50 text-black flex justify-center">

        <nav class="w-full">
            <ul class="text-white flex gap-1 items-center">
                <li class="bg-[#1D1D1DE1] h-[62px] flex flex-col items-center justify-center font-noodle w-full text-[14px] tracking-wider">
                    <a href="#" class="hover:text-luan-gold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-house-door mb-0.5" viewBox="0 0 16 16">
                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z" />
                        </svg>
                    </a>
                    Home
                </li>

                <li class="bg-[#1D1D1DE1] h-[62px] flex flex-col items-center justify-center font-noodle w-full text-[14px] tracking-wider">
                    <a href="#shows" class="hover:text-luan-gold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt mb-0.5" viewBox="0 0 16 16">
                            <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </a>
                    Cidades
                </li>


                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="bg-[#1D1D1DE1] h-[62px] flex flex-col items-center justify-center font-noodle w-full text-[14px] tracking-wider text-luan-gold">
                        <a href="meus_ingressos.php" class="hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-ticket-perforated mb-0.5" viewBox="0 0 16 16">
                                <path d="M4 4.85v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9zm-7 1.8v.9h1v-.9zm7 0v.9h1v-.9z" />
                                <path d="M1.5 3A1.5 1.5 0 0 0 0 4.5V6a.5.5 0 0 0 .5.5 1.5 1.5 0 1 1 0 3 .5.5 0 0 0-.5.5v1.5A1.5 1.5 0 0 0 1.5 13h13a1.5 1.5 0 0 0 1.5-1.5V10a.5.5 0 0 0-.5-.5 1.5 1.5 0 1 1 0-3 .5.5 0 0 0 .5-.5V4.5A1.5 1.5 0 0 0 14.5 3zM1 4.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v1.05a2.5 2.5 0 0 0 0 4.9v1.05a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-1.05a2.5 2.5 0 0 0 0-4.9z" />
                            </svg>
                        </a>
                        Ingressos
                    </li>
                <?php else: ?>
                    <li class="bg-[#1D1D1DE1] h-[62px] flex flex-col items-center justify-center font-noodle w-full text-[14px] tracking-wider">
                        <a href="login.php" class="hover:text-luan-gold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person mb-0.5" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                            </svg>
                        </a>
                        Entrar
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>
    <main>
        <section class="relative min-h-[100dvh] md:h-[85vh] flex flex-col items-center justify-center overflow-hidden bg-pure-black px-6 pt-[100px] md:pt-[0px]">
            <img src="./images/luan-video.avif"
                alt="Fundo Show Allianz Parque"
                class="absolute inset-0 w-full h-full object-cover z-0 grayscale opacity-40 blur-[2px]">

            <div class="absolute inset-0 bg-gradient-to-b from-luan-gold/20 to-pure-black/90 z-10"></div>

            <div class="text-center font-noodle text-white text-6xl tracking-wider absolute top-3 md:hidden leading-none">
                <h2>L<span class="text-luan-gold">S</span></h2>
            </div>

            <div class="relative z-20 text-center mt-10">
                <span class="text-luan-gold font-black tracking-[0.3em] uppercase text-xs mb-4 block">A maior tour do Brasil</span>

                <h2 class="text-8xl md:text-9xl font-black tracking-wider font-noodle text-white mb-6 uppercase italic text-center flex flex-col md:block">
                    Registro <span class="text-luan-gold text-center text-7xl md:text-9xl">Histórico</span>
                </h2>

                <p class="text-gray-200 max-w-xl mx-auto mb-10 font-medium p-3 text-[16px] md:p-0 md:text-lg">
                    Sinta a energia de um show inesquecível. Uma experiência imersiva que vai mudar a sua forma de viver a música.
                </p>

                <div class="flex flex-col md:flex-row items-center justify-center gap-4">
                    <button class="w-full sm:w-auto bg-luan-gold text-black font-black uppercase tracking-widest px-8 py-4 rounded-full hover:scale-105 transition transform duration-300 shadow-lg shadow-luan-gold/30">
                        Ver Datas Disponíveis
                    </button>

                    <button class="w-full sm:w-auto border border-white/20 text-white font-bold uppercase tracking-widest px-8 py-4 rounded-full hover:bg-white/10 transition duration-300 backdrop-blur-sm">
                        Ouvir no Spotify
                    </button>
                </div>
            </div>
        </section>

        <section id="shows" class="bg-pure-black px-6 py-20">
            <div class="max-w-7xl mx-auto">

                <div class="mb-12 text-left">
                    <h3 class="font-black uppercase mb-2 font-noodle text-4xl tracking-wider italic">Agenda</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php

                    $query = $conn->query("SELECT * FROM eventos WHERE data_evento >= NOW() ORDER BY data_evento ASC");

                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $data = new DateTime($row['data_evento']);
                    ?>

                        <div class="group bg-gray-900/50 border border-white/5 p-8 rounded-3xl hover:border-luan-gold/50 transition-all duration-500 hover:-translate-y-2 flex flex-col h-full justify-between">

                            <div>
                                <div class="flex justify-between items-start">
                                    <div class="bg-luan-gold/10 text-luan-gold text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">
                                        Confirmado
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-2xl font-black text-white italic"><?php echo $data->format('d/m'); ?></span>
                                        <span class="text-xs text-gray-500 font-bold uppercase"><?php echo $data->format('Y'); ?></span>
                                    </div>
                                </div>

                                <h4 class="text-3xl font-black text-white mt-8 mb-2 uppercase tracking-tighter italic min-h-[80px] flex items-center">
                                    <?php echo $row['local_evento']; ?>
                                </h4>

                                <p class="text-gray-400 text-sm mb-6">Ingressos a partir de <span class="text-white font-bold">R$ <?php echo number_format($row['preco_base'], 2, ',', '.'); ?></span></p>
                            </div>

                            <a href="verificar_compra.php?id=<?php echo $row['id']; ?>" class="w-full block text-center py-4 bg-white/5 border border-white/10 text-white font-black uppercase text-[10px] tracking-widest rounded-xl hover:bg-luan-gold hover:text-black transition-all duration-500">
                                Garantir Ingresso
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section id="musica" class="px-6">

            <div class="relative z-10 max-w-7xl mx-auto flex flex-col md:flex-row justify-between gap-12 w-full">

                <div class="flex justify-between md:flex-col gap-6">
                    <div class="flex gap-4">
                        <h2 class="text-left text-5xl md:text-7xl text-white italic uppercase tracking-wider font-noodle">Música</h2>
                        <img src="./images/profile.jpg" class="hidden md:block h-14 w-14 rounded-full object-cover" alt="Luan Santana">
                    </div>

                    <div class="flex items-center gap-4 justify-center">
                        <img src="./images/Spotify_Full_Logo_RGB_Green.png" alt="Spotify" class="w-[130px] md:w-30 object-contain shrink-0">
                        <button class="hidden md:block bg-[#1DB954] text-black font-black px-8 py-3 rounded-full uppercase text-[10px] tracking-widest hover:scale-105 transition-all">
                            Acessar
                        </button>
                    </div>
                </div>

                <div></div>

                <div class="w-full md:w-[450px]">
                    <iframe class="hidden md:block" style="border-radius:12px" src="https://open.spotify.com/embed/album/0KfLuQzP3LZmGc573DVtb8?utm_source=generator&theme=0" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>

                    <div class="px-6 flex items-center justify-center mx-auto gap-4 md:hidden">
                        <div class="flex gap-3 flex-col">
                            <a href="https://open.spotify.com/intl-pt/album/0KfLuQzP3LZmGc573DVtb8" class="cursor-pointer" target="_blank">
                                <img src="./images/album02.jpeg" alt="Registro Histórico Parte 02" class="w-full rounded-md">
                            </a>
                            <a href="https://open.spotify.com/intl-pt/album/0KfLuQzP3LZmGc573DVtb8" class="cursor-pointer p-[2px_16px] text-[18px] bg-[#1CB955] font-noodle uppercase text-black font-black rounded-full text-center" target="_blank">Play</a>
                        </div>

                        <div class="flex gap-3 flex-col">
                            <div class="flex gap-3 flex-col">
                                <a href="https://open.spotify.com/intl-pt/album/2SauDbABHAubq54A5RUMxX" class="cursor-pointer" target="_blank">
                                    <img src="./images/album01.jpeg" alt="Registro Histórico Parte 01" class="w-full rounded-md">
                                </a>
                                <a href="https://open.spotify.com/intl-pt/album/2SauDbABHAubq54A5RUMxX" class="cursor-pointer p-[2px_16px] text-[18px] bg-[#1CB955] font-noodle uppercase text-black font-black rounded-full text-center" target="_blank">Play</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="frame" class="relative bg-cover bg-center py-32 bg-[url('./images/luan-video.avif')]">

            <div class="absolute inset-0 bg-gradient-to-b via-transparent to-transparent to-r-black/70"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-black/60"></div>

            <div class="relative z-10 max-w-[900px] mx-auto px-6 flex flex-col md:flex-row items-center gap-12 w-full">

                <div class="flex flex-col gap-12 pb-20 w-screen p-5">
                    <div class="flex items-center gap-4">
                        <h2 class="text-5xl font-bold text-white italic uppercase font-noodle tracking-wider md:text-6xl">Vídeos</h2>
                    </div>

                    <div class="w-full flex mx-auto px-2">
                        <iframe class="rounded-md mx-auto w-full border border-white border-[2px] p-3 h-[300px] md:h-[450px]" src="https://www.youtube.com/embed/ZYd2yeeEad4?si=OHK8BnnkGTMZJ3cU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>

                    <div class="justify-end flex">
                        <div class="hover:scale-x-110 duration-500 transition-all">
                            <a href="https://youtube.com/@luansantana?si=ASG1lRiSBnSnfqla" class="text-white uppercase italic flex items-center justify-end gap-3 text-[20px] px-2 font-noodle">
                                Se inscrever no
                                <svg data-v-e8744afb="" viewBox="0 0 46 53" class="h-14 fill-white">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3462 20.0001H12.1984V12.0875L8.45098 0H11.6175L13.6598 7.97774H13.8566L15.7958 0H18.9905L15.3368 11.6784L15.3462 20.0001ZM24.115 8.50773C24.1203 8.36228 24.0928 8.21749 24.0344 8.08396C23.9761 7.95043 23.8884 7.83154 23.7778 7.73599C23.65 7.6256 23.5013 7.54161 23.3405 7.48893C23.1796 7.43624 23.0098 7.41592 22.8409 7.42915C22.6883 7.42188 22.5357 7.44531 22.3924 7.49804C22.2492 7.55077 22.1181 7.63171 22.0071 7.73599C21.9009 7.83409 21.8174 7.95389 21.7625 8.08714C21.7075 8.22038 21.6823 8.36388 21.6886 8.50773V16.532C21.6689 16.8666 21.7721 17.1969 21.979 17.4618C22.0902 17.5749 22.225 17.6626 22.3738 17.7188C22.5227 17.775 22.6821 17.7984 22.8409 17.7872C23.012 17.8001 23.1839 17.7769 23.3454 17.7192C23.5068 17.6615 23.6542 17.5706 23.7778 17.4525C24.0056 17.1971 24.1233 16.8633 24.1057 16.5227L24.115 8.50773ZM22.8878 20.3721C22.3434 20.3998 21.7991 20.3149 21.2895 20.1228C20.7798 19.9307 20.316 19.6357 19.9273 19.2563C19.552 18.8574 19.2615 18.3875 19.0732 17.8747C18.8849 17.3619 18.8026 16.8167 18.8312 16.2716V8.6379C18.809 8.13013 18.898 7.62361 19.0921 7.15328C19.2862 6.68295 19.5807 6.25999 19.9554 5.91357C20.8004 5.20466 21.8859 4.84221 22.9908 4.90008C23.5073 4.88449 24.0218 4.97099 24.5043 5.15456C24.9868 5.33813 25.4277 5.6151 25.8013 5.96936C26.1705 6.33275 26.4594 6.76842 26.6498 7.24864C26.8401 7.72887 26.9276 8.24315 26.9068 8.75878V16.3646C26.9369 16.9062 26.856 17.4482 26.6693 17.958C26.4825 18.4678 26.1936 18.9347 25.8201 19.3307C25.4251 19.6883 24.9625 19.9645 24.4592 20.1433C23.9558 20.322 23.4217 20.3998 22.8878 20.3721ZM34.5046 18.373C34.0522 18.915 33.5105 19.3771 32.9026 19.7398C32.413 20.0336 31.8539 20.194 31.2819 20.2047C31.0032 20.2233 30.7242 20.1737 30.4694 20.0602C30.2145 19.9467 29.9917 19.7728 29.8204 19.5538C29.4397 18.9684 29.256 18.2783 29.2958 17.5826V5.272H32.1063V16.5599C32.0872 16.826 32.1493 17.0916 32.2843 17.3223C32.355 17.4022 32.4434 17.4648 32.5425 17.5052C32.6417 17.5455 32.7489 17.5625 32.8558 17.5547C33.1402 17.5256 33.4101 17.4159 33.6334 17.2386C33.9601 17.021 34.2509 16.7544 34.4953 16.4483V5.2906H37.3058V20.0001H34.4953L34.5046 18.373ZM28.0123 45.1607C27.7778 45.1636 27.5462 45.1093 27.3378 45.0026C27.0907 44.8717 26.8687 44.6985 26.682 44.4912V35.314C26.8413 35.1297 27.0354 34.978 27.2535 34.8677C27.4349 34.7708 27.6376 34.7197 27.8437 34.719C28.0085 34.7093 28.1733 34.7398 28.3235 34.8079C28.4738 34.876 28.6049 34.9795 28.7056 35.1095C28.932 35.443 29.0377 35.843 29.0054 36.2439V43.8404C29.0358 44.1942 28.9539 44.5486 28.7712 44.8539C28.6792 44.9622 28.5621 45.0468 28.4299 45.1002C28.2977 45.1537 28.1544 45.1744 28.0123 45.1607ZM36.8561 36.4949C36.8173 36.0358 36.9185 35.5758 37.1465 35.1746C37.2584 35.0376 37.4021 34.9296 37.5653 34.86C37.7285 34.7903 37.9063 34.7611 38.0834 34.7748C38.2609 34.7568 38.4401 34.7842 38.604 34.8541C38.768 34.9241 38.9112 35.0344 39.0202 35.1746C39.2483 35.5758 39.3495 36.0358 39.3107 36.4949V37.9919H36.8468L36.8561 36.4949ZM42.1961 42.0737H39.32V43.0965C39.3799 43.6715 39.2862 44.2519 39.0483 44.7795C38.9326 44.9107 38.7878 45.0135 38.6252 45.0797C38.4626 45.1458 38.2867 45.1736 38.1115 45.1607C37.9281 45.1785 37.7434 45.1453 37.5779 45.0648C37.4125 44.9844 37.2729 44.8598 37.1747 44.7051C36.946 44.201 36.8493 43.6477 36.8936 43.0965V40.3071H42.2336V36.5879C42.306 35.4284 41.9384 34.284 41.2031 33.3801C40.8245 32.9917 40.3653 32.6899 39.8572 32.4956C39.3492 32.3013 38.8046 32.2192 38.2614 32.255C37.6958 32.236 37.1324 32.3336 36.6067 32.5417C36.081 32.7497 35.6045 33.0637 35.2073 33.4637C34.4068 34.2823 33.9655 35.3822 33.98 36.5228V43.1337C33.9086 44.3391 34.2891 45.528 35.048 46.4717C35.419 46.8781 35.876 47.1981 36.3862 47.4087C36.8963 47.6192 37.4471 47.7152 37.9991 47.6898C38.5741 47.7326 39.1518 47.6527 39.6932 47.4555C40.2345 47.2582 40.727 46.9481 41.1375 46.5461C41.9069 45.5799 42.2815 44.3616 42.1868 43.1337L42.1961 42.0737ZM31.8908 36.123C31.9641 35.1424 31.7178 34.1645 31.1882 33.3336C30.9559 33.0232 30.6491 32.7756 30.2956 32.6131C29.9421 32.4507 29.5533 32.3787 29.1646 32.4038C28.7171 32.4071 28.2781 32.5256 27.8905 32.7478C27.4291 33.0102 27.0222 33.3573 26.6914 33.7706V27.327H23.8808V47.29H26.6914V46.1556C27.0071 46.5722 27.4139 46.9123 27.8811 47.1505C28.3335 47.3777 28.8358 47.4895 29.3426 47.4759C29.6984 47.4931 30.0533 47.4271 30.3787 47.2834C30.7041 47.1397 30.991 46.9222 31.2163 46.6484C31.6956 45.939 31.9261 45.0926 31.8721 44.2402L31.8908 36.123ZM21.1359 32.5711H18.3253V43.7288C18.0807 44.0347 17.79 44.3013 17.4634 44.5191C17.2376 44.6904 16.9685 44.7966 16.6858 44.826C16.5788 44.836 16.4708 44.82 16.3713 44.7796C16.2717 44.7391 16.1836 44.6752 16.1144 44.5935C15.9831 44.3616 15.9244 44.0962 15.9457 43.8311V32.5711H13.1352V44.8725C13.0843 45.5641 13.2548 46.2539 13.6224 46.8436C13.7915 47.0656 14.0137 47.2422 14.2688 47.3575C14.524 47.4727 14.8041 47.523 15.0838 47.5038C15.6552 47.4884 16.2131 47.3284 16.7046 47.0389C17.3251 46.6902 17.8798 46.2372 18.3441 45.7V47.3272H21.1546L21.1359 32.5711ZM13.2102 27.327H3.56064V30.228H6.8115V47.29H9.9593V30.228H13.2102V27.327ZM45.6906 46.2579C45.682 47.1142 45.5033 47.9604 45.1646 48.7481C44.8259 49.5357 44.334 50.2493 43.7169 50.8479C43.0999 51.4464 42.3699 51.9183 41.5687 52.2364C40.7676 52.5544 39.9111 52.7125 39.0483 52.7014C33.8083 52.9122 28.4589 53.0114 23.0002 52.999C17.5384 52.999 12.1796 52.9153 6.95203 52.7014C6.08925 52.7125 5.23275 52.5544 4.43163 52.2364C3.63051 51.9183 2.90051 51.4464 2.28346 50.8479C1.66641 50.2493 1.17445 49.5357 0.835772 48.7481C0.497092 47.9604 0.318346 47.1142 0.30979 46.2579C0.0849468 43.4685 -0.00873228 40.6232 0.000636175 37.8059C0.0100046 34.9886 0.0849468 32.2271 0.30979 29.3633C0.318346 28.507 0.497092 27.6607 0.835772 26.8731C1.17445 26.0855 1.66641 25.3719 2.28346 24.7733C2.90051 24.1747 3.63051 23.7029 4.43163 23.3848C5.23275 23.0667 6.08925 22.9087 6.95203 22.9197C12.1796 22.7059 17.5384 22.6129 23.0002 22.6222C28.462 22.6315 33.8114 22.7059 39.0483 22.9197C39.9111 22.9087 40.7676 23.0667 41.5687 23.3848C42.3699 23.7029 43.0999 24.1747 43.7169 24.7733C44.334 25.3719 44.8259 26.0855 45.1646 26.8731C45.5033 27.6607 45.682 28.507 45.6906 29.3633C45.9029 32.1837 46.006 34.9979 45.9997 37.8059C45.9935 40.6139 45.8904 43.4313 45.6906 46.2579Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="mt-[-145px]">
            <div class="flex justify-center bg-[url('./images/bgdesk-contact.webp')] bg-cover bg-center relative">
                <div class="absolute inset-0 bg-pure-black/60"></div>

                <div class="flex items-center justify-center flex-col p-20 relative z-10">
                    <h2 class="uppercase text-7xl italic font-noodle mb-12 drop-shadow-[0_2px_10px_rgba(212,175,55,0.4)]">
                        Contato
                    </h2>

                    <div class="flex flex-wrap justify-center gap-8 uppercase font-noodle text-[32px] text-white">
                        <a href="#" class="hover:text-luan-gold transition-all duration-300 hover:scale-110">Escritório Ls</a>
                        <a href="#shows" class="hover:text-luan-gold transition-all duration-300 hover:scale-110">Shows</a>
                        <a href="#" class="hover:text-luan-gold transition-all duration-300 hover:scale-110">Central de fás</a>
                        <a href="#" class="hover:text-luan-gold transition-all duration-300 hover:scale-110">Publicidade</a>
                        <a href="#" class="hover:text-luan-gold transition-all duration-300 hover:scale-110">Imprensa</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-pure-black pt-3 text-center mt-[-5px] relative z-20">
        <div class="container flex justify-center mx-auto p-5">
            <h3 class="text-3xl uppercase flex flex-col tracking-widest items-center text-white/80 border-r border-white/80 pr-4">
                Luan
                <span class="tracking-[0.7rem] text-[10px] text-white/70">Santana</span>
            </h3>

            <p class="font-bold text-white/70 tracking-tight [text-shadow:_0_1px_5px_rgb(0_0_0_/_100%)] text-xs flex flex-col p-4">
                Desenvolvido por
                <a href="https://kamily-reis.vercel.app/" target="_blank" class="hover:text-luan-gold transition-colors">@Kamily Reis</a>
            </p>
        </div>
    </footer>
    <script src="./script/index.js"></script>
</body>

</html>