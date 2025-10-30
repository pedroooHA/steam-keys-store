-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/10/2025 às 02:02
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
-- Estrutura para tabela `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_jogo` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cart`
--

INSERT INTO `cart` (`id`, `id_usuario`, `id_jogo`, `quantidade`, `preco_unitario`, `criado_em`) VALUES
(6, 3, 85, 1, 229.90, '2025-10-30 00:16:32');

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
(4, 'Aventura'),
(5, 'Corrida'),
(9, 'FPS'),
(3, 'Indie'),
(6, 'Luta'),
(7, 'Plataforma'),
(2, 'RPG'),
(8, 'Terror');

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
(2, 'God of War Ragnarök', 159.00, 1, 'ZXCVB-NMQWE-RTYUI', 'Jogo de ação-aventura da franquia God of War, onde Kratos e Atreus enfrentam mitologia nórdica e eventos de fim-do-mundo (“Ragnarök”).', '2025-09-25 00:53:48', 'https://upload.wikimedia.org/wikipedia/pt/a/a5/God_of_War_Ragnar%C3%B6k_capa.jpg'),
(3, 'Marvel’s Spider‑Man 2', 159.00, 1, 'LDAS-DJIO-APOS', 'Jogo de super-herói com os personagens Peter Parker e Miles Morales, mundo aberto em Nova York, com combate, narrativa cinematográfica e viagens de aranha.', '2025-09-25 01:23:10', 'https://image.api.playstation.com/vulcan/ap/rnd/202306/1219/97e9f5fa6e50c185d249956c6f198a2652a9217e69a59ecd.jpg'),
(4, 'Horizon Forbidden West', 99.00, 4, 'MOPA-KODP-KLAM', 'Sequência de Horizon Zero Dawn onde a protagonista Aloy explora paisagens pós-apocalípticas, enfrenta máquinas e descobre mistérios.', '2025-09-25 02:35:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2420110/header.jpg?t=1750953213'),
(6, 'Minecraft', 59.00, 3, 'UOIP-XZXC-KOPC', 'Jogo muito popular de mundo aberto onde se pode explorar, construir e sobreviver, com apelo amplo de público.', '2025-09-25 02:45:41', 'https://upload.wikimedia.org/wikipedia/pt/9/9c/Minecraft_capa.png'),
(28, 'The Witcher 3: Wild Hunt', 129.00, 1, 'TW3-KEY-012', 'Acompanhe Geralt de Rivia em uma jornada épica por um vasto mundo de fantasia.', '2025-10-29 22:49:51', 'the-witcher-3.jpg'),
(30, 'Elden Ring Shadow of the Erdtree', 199.00, 1, 'ERSE-KEY-014', 'Expansão massiva de Elden Ring, com novas áreas e chefes lendários.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2778580/header.jpg?t=1744748042'),
(31, 'The Last of Us Part I', 229.00, 4, 'TLOU1-KEY-015', 'Remake do clássico pós-apocalíptico da Naughty Dog.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1888930/header.jpg?t=1750959031'),
(32, 'The Last of Us Part II', 189.00, 2, 'TLOU2-KEY-016', 'Sequência premiada com foco em sobrevivência e narrativa intensa.', '2025-10-29 22:49:51', 'the-last-of-us-part2.jpg'),
(33, 'GTA V', 99.00, 1, 'GTAV-KEY-017', 'Explore Los Santos em um dos jogos mais populares de todos os tempos.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3240220/header.jpg?t=1753974947'),
(35, 'Call of Duty: Modern Warfare III', 299.00, 9, 'CODMW3-KEY-019', 'Ação intensa em batalhas modernas com multiplayer competitivo.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3595270/7d0f21912a075c33bbb5ea558100e187ceb234ac/header.jpg?t=1758060267'),
(37, 'Diablo IV', 249.00, 2, 'DIABLO4-KEY-021', 'Retorne ao inferno neste RPG de ação sombrio e visceral.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/80f21a42e378b93e8fbb68ee43103be8ab84891b/header.jpg?t=1758649357'),
(40, 'Street Fighter 6', 249.00, 2, 'SF6-KEY-024', 'Nova geração da luta clássica, com gráficos realistas e jogabilidade fluida.', '2025-10-29 22:49:51', 'street-fighter-6.jpg'),
(45, 'Starfield', 299.00, 1, 'STARFIELD-KEY-029', 'Explore o universo neste RPG espacial da Bethesda.', '2025-10-29 22:49:51', 'starfield.jpg'),
(47, 'Devil May Cry 5', 129.90, 1, 'DMC5-STEAM-KEY-001', 'Ação intensa e estilosa com combos insanos e personagens carismáticos.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/601150/header.jpg'),
(48, 'Just Cause 4', 79.90, 1, 'JC4-STEAM-KEY-002', 'Explosões, caos e liberdade em um enorme mundo aberto tropical.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/517630/header.jpg'),
(49, 'Control', 119.90, 1, 'CTRL-STEAM-KEY-003', 'Um thriller sobrenatural com poderes telecinéticos e mistério em um prédio vivo.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/870780/header.jpg'),
(50, 'Baldur’s Gate 3', 249.90, 2, 'BG3-STEAM-KEY-004', 'Um RPG épico baseado em D&D com escolhas profundas e combate tático.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1086940/header.jpg'),
(51, 'Final Fantasy XVI', 299.90, 2, 'FFXVI-STEAM-KEY-005', 'A mais nova aventura da lendária série Final Fantasy, cheia de ação e drama.', '2025-10-29 23:15:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2515020/header.jpg?t=1741059170'),
(52, 'Dragon’s Dogma 2', 279.90, 2, 'DD2-STEAM-KEY-006', 'Explore um vasto mundo e lute contra criaturas colossais neste RPG de ação.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2054970/header.jpg'),
(53, 'Hades', 89.90, 3, 'HADES-STEAM-KEY-007', 'Um roguelike viciante com combate rápido e história envolvente baseada na mitologia grega.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1145360/header.jpg'),
(54, 'Celeste', 39.90, 3, 'CELESTE-STEAM-KEY-008', 'Um jogo de plataforma desafiador sobre superação e autodescoberta.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/504230/header.jpg'),
(55, 'Hollow Knight', 49.90, 3, 'HK-STEAM-KEY-009', 'Explore cavernas misteriosas e lute contra inimigos sombrios em um metroidvania impecável.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/367520/header.jpg'),
(56, 'Uncharted: Legacy of Thieves Collection', 199.90, 4, 'UNCHARTED-STEAM-KEY-010', 'Aventura cinematográfica com ação, exploração e tesouros perdidos.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1659420/header.jpg'),
(57, 'Tomb Raider (2013)', 59.90, 4, 'TR13-STEAM-KEY-011', 'A origem de Lara Croft em uma intensa aventura de sobrevivência.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/203160/header.jpg'),
(58, 'Life is Strange: True Colors', 149.90, 4, 'LIS-TC-STEAM-KEY-012', 'Um jogo narrativo sobre empatia, amizade e decisões que mudam tudo.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/936790/header.jpg'),
(59, 'Need for Speed Heat', 99.90, 5, 'NFSH-STEAM-KEY-013', 'Corra de dia, fuja da polícia à noite. Customize seu carro e domine as ruas.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1222680/header.jpg'),
(60, 'F1 24', 279.90, 5, 'F124-STEAM-KEY-014', 'A mais realista experiência de Fórmula 1, com todos os pilotos e circuitos oficiais.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2488620/header.jpg'),
(61, 'The Crew Motorfest', 259.90, 5, 'TCM-STEAM-KEY-015', 'Participe de festivais automotivos em um enorme mundo aberto tropical.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1495320/header.jpg'),
(62, 'Tekken 8', 299.90, 6, 'TEKKEN8-STEAM-KEY-016', 'A mais recente edição da franquia lendária de luta 3D.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1778820/header.jpg'),
(63, 'Street Fighter 6', 299.90, 6, 'SF6-STEAM-KEY-017', 'Combates dinâmicos, novos modos e personagens icônicos retornando.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1364780/header.jpg'),
(64, 'Mortal Kombat 1', 319.90, 6, 'MK1-STEAM-KEY-018', 'Um reboot brutal da série com gráficos de ponta e fatalidades épicas.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1971870/header.jpg'),
(65, 'Ori and the Will of the Wisps', 99.90, 7, 'ORI2-STEAM-KEY-019', 'Uma aventura comovente e visualmente deslumbrante em um mundo de fantasia.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1057090/header.jpg'),
(66, 'Rayman Legends', 59.90, 7, 'RAYLEG-STEAM-KEY-020', 'Um dos melhores jogos de plataforma 2D já feitos, cheio de criatividade.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/242550/header.jpg'),
(67, 'Cuphead', 79.90, 7, 'CUPHEAD-STEAM-KEY-021', 'Um desafio retrô com visuais inspirados em desenhos dos anos 30.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/268910/header.jpg'),
(69, 'Dead Space Remake', 249.90, 8, 'DSR-STEAM-KEY-023', 'Sobreviva ao horror no espaço em um remake aterrorizante.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1693980/header.jpg'),
(70, 'Outlast Trials', 169.90, 8, 'OT-STEAM-KEY-024', 'Experimente o terror cooperativo em uma instalação experimental.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1304930/header.jpg'),
(71, 'Counter-Strike 2', 0.00, 9, 'CS2-STEAM-KEY-025', 'A evolução do clássico FPS competitivo da Valve.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/730/header.jpg'),
(72, 'Rainbow Six Siege', 89.90, 9, 'R6S-STEAM-KEY-026', 'FPS tático com foco em estratégia e trabalho em equipe.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/359550/header.jpg'),
(73, 'Destiny 2', 0.00, 9, 'D2-STEAM-KEY-027', 'FPS cooperativo online com elementos de RPG e ficção científica.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1085660/header.jpg'),
(74, 'Marvel’s Spider-Man Remastered', 249.90, 1, 'SPIDERMAN-STEAM-001', 'Balance-se por Nova York com o Homem-Aranha em uma história emocionante e cheia de ação.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1817070/header.jpg'),
(75, 'Watch Dogs: Legion', 99.90, 1, 'WDL-STEAM-002', 'Monte sua resistência em uma Londres futurista e lute contra um sistema opressor.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/2239550/header.jpg'),
(76, 'Mad Max', 59.90, 1, 'MMAX-STEAM-003', 'Sobreviva em um mundo pós-apocalíptico dominado por gangues e deserto.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/234140/header.jpg'),
(77, 'The Witcher 3: Wild Hunt', 99.90, 2, 'TW3-STEAM-004', 'Viva como Geralt de Rívia em um dos maiores RPGs já criados.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/292030/header.jpg'),
(78, 'Elden Ring', 249.90, 2, 'ELDENRING-STEAM-005', 'Explore as Terras Intermédias neste épico de mundo aberto e combate desafiador.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1245620/header.jpg'),
(79, 'Starfield', 349.90, 2, 'STARFIELD-STEAM-006', 'Um RPG espacial da Bethesda com centenas de planetas e liberdade total.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1716740/header.jpg'),
(80, 'Slay the Spire', 49.90, 3, 'STS-STEAM-007', 'Construa seu baralho e lute em batalhas estratégicas neste roguelike aclamado.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/646570/header.jpg'),
(81, 'The Binding of Isaac: Rebirth', 34.90, 3, 'ISAAC-STEAM-008', 'Um roguelike sombrio e viciante cheio de segredos e bizarrices.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/250900/header.jpg'),
(82, 'Dead Cells', 79.90, 3, 'DCELLS-STEAM-009', 'Ação fluida e desafios constantes em um metroidvania roguelike.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/588650/header.jpg'),
(83, 'The Legend of Zelda: Tears of the Kingdom', 349.90, 4, 'ZELDA-TOK-STEAM-010', 'Explore o reino de Hyrule em uma aventura inesquecível cheia de liberdade.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/239140/header.jpg'),
(84, 'Detroit: Become Human', 159.90, 4, 'DETROIT-STEAM-011', 'Decisões morais e narrativa profunda em um futuro com androides conscientes.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1222140/header.jpg'),
(85, 'A Plague Tale: Requiem', 229.90, 4, 'PLAGUE-STEAM-012', 'Uma história comovente de sobrevivência e sacrifício em tempos sombrios.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1182900/header.jpg'),
(87, 'Assetto Corsa Competizione', 139.90, 5, 'ACC-STEAM-014', 'Simulador oficial do GT World Challenge, com física e som realistas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/805550/header.jpg'),
(88, 'Wreckfest', 89.90, 5, 'WRFST-STEAM-015', 'Corridas destrutivas com colisões realistas e muita diversão.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/228380/header.jpg'),
(89, 'Guilty Gear Strive', 229.90, 6, 'GGS-STEAM-016', 'Visual impressionante e trilha sonora eletrizante neste jogo de luta aclamado.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1384160/header.jpg'),
(90, 'Dragon Ball FighterZ', 139.90, 6, 'DBFZ-STEAM-017', 'Combates intensos com personagens icônicos de Dragon Ball Z.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/678950/header.jpg'),
(91, 'Injustice 2', 79.90, 6, 'INJ2-STEAM-018', 'Super-heróis e vilões da DC lutam em batalhas épicas cheias de poder.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/627270/header.jpg'),
(92, 'Super Meat Boy', 29.90, 7, 'SMB-STEAM-019', 'Desafios insanos e reflexos rápidos neste clássico de plataforma.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/40800/header.jpg'),
(93, 'Little Nightmares II', 99.90, 7, 'LN2-STEAM-020', 'Um pesadelo sombrio e misterioso em um mundo de infância distorcido.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/860510/header.jpg'),
(94, 'It Takes Two', 149.90, 7, 'ITT-STEAM-021', 'Uma aventura cooperativa criativa e divertida sobre união e superação.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1426210/header.jpg'),
(95, 'Resident Evil Village', 179.90, 8, 'REVILLAGE-STEAM-022', 'Explore uma vila macabra cheia de segredos e criaturas grotescas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1196590/header.jpg'),
(96, 'Phasmophobia', 49.90, 8, 'PHASMO-STEAM-023', 'Caça fantasmas cooperativo com terror psicológico e realismo.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/739630/header.jpg'),
(97, 'The Medium', 129.90, 8, 'MEDIUM-STEAM-024', 'Um suspense psicológico com mundos paralelos e atmosfera intensa.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1293160/header.jpg'),
(98, 'DOOM Eternal', 179.90, 9, 'DOOME-STEAM-025', 'Ação frenética e brutal em um dos FPS mais intensos já feitos.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/782330/header.jpg'),
(99, 'Battlefield 2042', 199.90, 9, 'BF2042-STEAM-026', 'Combates massivos em campos de batalha futuristas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1517290/header.jpg'),
(100, 'Far Cry 6', 179.90, 9, 'FC6-STEAM-027', 'Lute contra um regime ditatorial em uma ilha tropical.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/2369390/header.jpg');

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
(2, 'Admin', 'admin@exemplo.com', '$2y$10$FIiFjAaTob/ITvwsTpRSG.bNb084W9LBRyEncZmYtSeLa3438myuW', '2025-09-25 01:44:21', 'admin'),
(3, 'kevin', 'kevin@gmail.com', '$2y$10$FIiFjAaTob/ITvwsTpRSG.bNb084W9LBRyEncZmYtSeLa3438myuW', '2025-10-29 22:52:24', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
