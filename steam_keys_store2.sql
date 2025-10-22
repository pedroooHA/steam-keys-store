-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/10/2025 às 03:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `steam_keys_store`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Ação'),
(3, 'Indie'),
(2, 'RPG');

-- --------------------------------------------------------

--
-- Estrutura para tabela `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `steam_key` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `games`
--

INSERT INTO `games` (`id`, `title`, `price`, `category_id`, `steam_key`, `description`, `created_at`, `image`) VALUES
(1, 'Elden Ring', 199.00, 2, 'Z9Y8X-7W6V5-U4T3S', 'Um grande RPG de ação em mundo aberto criado pela FromSoftware com design de Hidetaka Miyazaki e colaboração de George R.R. Martin.', '2025-09-25 00:53:48', 'https://upload.wikimedia.org/wikipedia/pt/0/0d/Elden_Ring_capa.jpg'),
(2, 'God of War Ragnarök', 159.00, 1, 'ZXCVB-NMQWE-RTYUI', 'Jogo de ação-aventura da franquia God of War, onde Kratos e Atreus enfrentam mitologia nórdica e eventos de fim-do-mundo (“Ragnarök”).', '2025-09-25 00:53:48', 'https://upload.wikimedia.org/wikipedia/pt/a/a5/God_of_War_Ragnar%C3%B6k_capa.jpg'),
(3, 'Marvel’s Spider‑Man 2', 159.00, 1, 'LDAS-DJIO-APOS', 'Jogo de super-herói com os personagens Peter Parker e Miles Morales, mundo aberto em Nova York, com combate, narrativa cinematográfica e viagens de aranha.', '2025-09-25 01:23:10', 'https://image.api.playstation.com/vulcan/ap/rnd/202306/1219/97e9f5fa6e50c185d249956c6f198a2652a9217e69a59ecd.jpg'),
(4, 'Horizon Forbidden West', 99.00, 1, 'MOPA-KODP-KLAM', 'Sequência de Horizon Zero Dawn onde a protagonista Aloy explora paisagens pós-apocalípticas, enfrenta máquinas e descobre mistérios.', '2025-09-25 02:35:46', 'https://upload.wikimedia.org/wikipedia/en/thumb/6/69/Horizon_Forbidden_West_cover_art.jpg/250px-Horizon_Forbidden_West_cover_art.jpg'),
(5, 'The Legend of Zelda: Tears of the Kingdom', 129.00, 1, 'JOSP-NXIO-NXKI', 'Sequência de The Legend of Zelda: Breath of the Wild, ampla exploração em céu e terra, nova mecânica de construção, física expansiva.', '2025-09-25 02:43:53', 'https://upload.wikimedia.org/wikipedia/en/f/fb/The_Legend_of_Zelda_Tears_of_the_Kingdom_cover.jpg'),
(6, 'Minecraft', 59.00, 1, 'UOIP-XZXC-KOPC', 'Jogo muito popular de mundo aberto onde se pode explorar, construir e sobreviver, com apelo amplo de público.', '2025-09-25 02:45:41', 'https://upload.wikimedia.org/wikipedia/pt/9/9c/Minecraft_capa.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `created_at`, `role`) VALUES
(1, 'pedro', 'pedro@gmail.com', '$2y$10$dZ62KBRE9pRP6eXdCl8us.XaIZTmLZLwGdy4MFPy.gPCCDV1f0ijy', '2025-09-25 01:01:41', 'user'),
(2, 'Admin', 'admin@exemplo.com', '$2y$10$FIiFjAaTob/ITvwsTpRSG.bNb084W9LBRyEncZmYtSeLa3438myuW', '2025-09-25 01:44:21', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices de tabela `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
