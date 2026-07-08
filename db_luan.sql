-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/07/2026 às 05:07
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_luan`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `nome_show` varchar(100) DEFAULT 'Luan Santana - Registro Histórico 2026',
  `data_evento` datetime DEFAULT NULL,
  `local_evento` varchar(150) DEFAULT NULL,
  `capacidade_total` int(11) DEFAULT NULL,
  `preco_base` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `nome_show`, `data_evento`, `local_evento`, `capacidade_total`, `preco_base`) VALUES
(1, 'Luan Santana - Registro Histórico 2026', '2026-07-20 21:00:00', 'Allianz Parque - SP', 45000, 150.00),
(2, 'Luan Santana - Registro Histórico 2026', '2026-09-21 21:00:00', 'Maracana - RJ', 78000, 250.00),
(3, 'Luan Santana - Registro Histórico 2026', '2026-08-10 20:30:00', 'Pedreira Paulo Leminski - PR', 25000, 190.00),
(4, 'Luan Santana - Registro Histórico 2026', '2026-11-12 20:30:00', 'Estádio do Cuiába - MT', 29000, 210.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingressos`
--

CREATE TABLE `ingressos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `evento_id` int(11) DEFAULT NULL,
  `setor_escolhido` enum('Pista','VIP','Camarote') DEFAULT 'Pista',
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `status_pagamento` enum('Pendente','Aprovado','Cancelado') DEFAULT 'Pendente',
  `data_compra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ingressos`
--

INSERT INTO `ingressos` (`id`, `usuario_id`, `evento_id`, `setor_escolhido`, `valor_pago`, `status_pagamento`, `data_compra`) VALUES
(1, 1, 3, NULL, 190.00, 'Aprovado', '2026-07-08 01:13:41'),
(2, 1, 3, 'Camarote', 340.00, 'Aprovado', '2026-07-08 01:16:16'),
(3, 1, 3, 'Camarote', 340.00, 'Aprovado', '2026-07-08 01:17:52'),
(4, 1, 1, 'Camarote', 300.00, 'Aprovado', '2026-07-08 01:25:12'),
(5, 1, 1, 'Camarote', 300.00, 'Aprovado', '2026-07-08 01:27:41'),
(6, 1, 1, 'Camarote', 300.00, 'Aprovado', '2026-07-08 01:30:42'),
(7, 1, 4, 'Camarote', 360.00, 'Aprovado', '2026-07-08 01:32:34'),
(8, 1, 1, 'Camarote', 300.00, 'Aprovado', '2026-07-08 01:33:19'),
(9, 1, 3, 'Camarote', 340.00, 'Aprovado', '2026-07-08 01:38:16'),
(10, 1, 3, 'Pista', 190.00, 'Aprovado', '2026-07-08 01:39:17'),
(11, 1, 1, 'Pista', 150.00, 'Aprovado', '2026-07-08 02:02:42'),
(12, 1, 4, 'Camarote', 360.00, 'Aprovado', '2026-07-08 02:55:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(200) DEFAULT NULL,
  `nivel_acesso` enum('admin','usuario') DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel_acesso`) VALUES
(1, 'Kamily', 'kamily123@gmail.com', '$2y$10$S82ySa7Tsd4tbfe0rNZYK.1yCDTHLQsQ2Z9FVqIiBCDJM.2obDSoG', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ingressos`
--
ALTER TABLE `ingressos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `evento_id` (`evento_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `ingressos`
--
ALTER TABLE `ingressos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ingressos`
--
ALTER TABLE `ingressos`
  ADD CONSTRAINT `ingressos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `ingressos_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
