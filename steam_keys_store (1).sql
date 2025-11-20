-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/11/2025 às 23:34
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
(43, 3, 123, 1, 89.90, '2025-11-14 00:54:28'),
(47, 2, 123, 1, 89.90, '2025-11-17 23:17:29');

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
  `image` varchar(255) DEFAULT NULL,
  `estoque` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `games`
--

INSERT INTO `games` (`id`, `title`, `price`, `category_id`, `steam_key`, `description`, `created_at`, `image`, `estoque`) VALUES
(2, 'God of War Ragnarök', 159.00, 1, 'ZXCVB-NMQWE-RTYUI', 'Jogo de ação-aventura da franquia God of War, onde Kratos e Atreus enfrentam mitologia nórdica e eventos de fim-do-mundo (“Ragnarök”).', '2025-09-25 00:53:48', 'https://upload.wikimedia.org/wikipedia/pt/a/a5/God_of_War_Ragnar%C3%B6k_capa.jpg', 0),
(3, 'Marvel’s Spider‑Man 2', 159.00, 1, 'LDAS-DJIO-APOS', 'Jogo de super-herói com os personagens Peter Parker e Miles Morales, mundo aberto em Nova York, com combate, narrativa cinematográfica e viagens de aranha.', '2025-09-25 01:23:10', 'https://image.api.playstation.com/vulcan/ap/rnd/202306/1219/97e9f5fa6e50c185d249956c6f198a2652a9217e69a59ecd.jpg', 0),
(4, 'Horizon Forbidden West', 99.00, 4, 'MOPA-KODP-KLAM', 'Sequência de Horizon Zero Dawn onde a protagonista Aloy explora paisagens pós-apocalípticas, enfrenta máquinas e descobre mistérios.', '2025-09-25 02:35:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2420110/header.jpg?t=1750953213', 0),
(6, 'Minecraft', 59.00, 3, 'UOIP-XZXC-KOPC', 'Jogo muito popular de mundo aberto onde se pode explorar, construir e sobreviver, com apelo amplo de público.', '2025-09-25 02:45:41', 'https://upload.wikimedia.org/wikipedia/pt/9/9c/Minecraft_capa.png', 1),
(30, 'Elden Ring Shadow of the Erdtree', 199.00, 1, 'ERSE-KEY-014', 'Expansão massiva de Elden Ring, com novas áreas e chefes lendários.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2778580/header.jpg?t=1744748042', 0),
(31, 'The Last of Us Part I', 229.00, 4, 'TLOU1-KEY-015', 'Remake do clássico pós-apocalíptico da Naughty Dog.', '2025-10-29 22:49:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2215430/header.jpg', 0),
(32, 'The Last of Us Part II', 189.00, 2, 'TLOU2-KEY-016', 'Sequência premiada com foco em sobrevivência e narrativa intensa.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2531310/header.jpg?t=1750959180', 0),
(33, 'GTA V', 99.00, 1, 'GTAV-KEY-017', 'Explore Los Santos em um dos jogos mais populares de todos os tempos.', '2025-10-29 22:49:51', 'https://cdn.akamai.steamstatic.com/steam/apps/271590/header.jpg', 0),
(35, 'Call of Duty: Modern Warfare III', 299.00, 9, 'CODMW3-KEY-019', 'Ação intensa em batalhas modernas com multiplayer competitivo.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3595270/7d0f21912a075c33bbb5ea558100e187ceb234ac/header.jpg?t=1758060267', 0),
(37, 'Diablo IV', 249.00, 2, 'DIABLO4-KEY-021', 'Retorne ao inferno neste RPG de ação sombrio e visceral.', '2025-10-29 22:49:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2344520/80f21a42e378b93e8fbb68ee43103be8ab84891b/header.jpg?t=1758649357', 0),
(47, 'Devil May Cry 5', 129.90, 1, 'DMC5-STEAM-KEY-001', 'Ação intensa e estilosa com combos insanos e personagens carismáticos.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/601150/header.jpg', 0),
(48, 'Just Cause 4', 79.90, 1, 'JC4-STEAM-KEY-002', 'Explosões, caos e liberdade em um enorme mundo aberto tropical.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/517630/header.jpg', 0),
(49, 'Control', 119.90, 1, 'CTRL-STEAM-KEY-003', 'Um thriller sobrenatural com poderes telecinéticos e mistério em um prédio vivo.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/870780/header.jpg', 0),
(50, 'Baldur’s Gate 3', 249.90, 2, 'BG3-STEAM-KEY-004', 'Um RPG épico baseado em D&D com escolhas profundas e combate tático.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1086940/header.jpg', 0),
(51, 'Final Fantasy XVI', 299.90, 2, 'FFXVI-STEAM-KEY-005', 'A mais nova aventura da lendária série Final Fantasy, cheia de ação e drama.', '2025-10-29 23:15:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2515020/header.jpg?t=1741059170', 0),
(52, 'Dragon’s Dogma 2', 279.90, 2, 'DD2-STEAM-KEY-006', 'Explore um vasto mundo e lute contra criaturas colossais neste RPG de ação.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2054970/header.jpg', 0),
(53, 'Hades', 89.90, 3, 'HADES-STEAM-KEY-007', 'Um roguelike viciante com combate rápido e história envolvente baseada na mitologia grega.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1145360/header.jpg', 0),
(54, 'Celeste', 39.90, 3, 'CELESTE-STEAM-KEY-008', 'Um jogo de plataforma desafiador sobre superação e autodescoberta.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/504230/header.jpg', 0),
(56, 'Uncharted: Legacy of Thieves Collection', 199.90, 4, 'UNCHARTED-STEAM-KEY-010', 'Aventura cinematográfica com ação, exploração e tesouros perdidos.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1659420/header.jpg', 0),
(57, 'Tomb Raider (2013)', 59.90, 4, 'TR13-STEAM-KEY-011', 'A origem de Lara Croft em uma intensa aventura de sobrevivência.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/203160/header.jpg', 0),
(58, 'Life is Strange: True Colors', 149.90, 4, 'LIS-TC-STEAM-KEY-012', 'Um jogo narrativo sobre empatia, amizade e decisões que mudam tudo.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/936790/header.jpg', 0),
(59, 'Need for Speed Heat', 99.90, 5, 'NFSH-STEAM-KEY-013', 'Corra de dia, fuja da polícia à noite. Customize seu carro e domine as ruas.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1222680/header.jpg', 0),
(60, 'F1 24', 279.90, 5, 'F124-STEAM-KEY-014', 'A mais realista experiência de Fórmula 1, com todos os pilotos e circuitos oficiais.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2488620/header.jpg', 0),
(61, 'The Crew Motorfest', 259.90, 5, 'TCM-STEAM-KEY-015', 'Participe de festivais automotivos em um enorme mundo aberto tropical.', '2025-10-29 23:15:51', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2698940/header.jpg?t=1760987162', 0),
(62, 'Tekken 8', 299.90, 6, 'TEKKEN8-STEAM-KEY-016', 'A mais recente edição da franquia lendária de luta 3D.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1778820/header.jpg', 0),
(63, 'Street Fighter 6', 299.90, 6, 'SF6-STEAM-KEY-017', 'Combates dinâmicos, novos modos e personagens icônicos retornando.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/2073850/header.jpg', 0),
(64, 'Mortal Kombat 1', 319.90, 6, 'MK1-STEAM-KEY-018', 'Um reboot brutal da série com gráficos de ponta e fatalidades épicas.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1971870/header.jpg', 0),
(65, 'Ori and the Will of the Wisps', 99.90, 7, 'ORI2-STEAM-KEY-019', 'Uma aventura comovente e visualmente deslumbrante em um mundo de fantasia.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1057090/header.jpg', 0),
(66, 'Rayman Legends', 59.90, 7, 'RAYLEG-STEAM-KEY-020', 'Um dos melhores jogos de plataforma 2D já feitos, cheio de criatividade.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/242550/header.jpg', 0),
(67, 'Cuphead', 79.90, 7, 'CUPHEAD-STEAM-KEY-021', 'Um desafio retrô com visuais inspirados em desenhos dos anos 30.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/268910/header.jpg', 0),
(69, 'Dead Space Remake', 249.90, 8, 'DSR-STEAM-KEY-023', 'Sobreviva ao horror no espaço em um remake aterrorizante.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1693980/header.jpg', 0),
(70, 'Outlast Trials', 169.90, 8, 'OT-STEAM-KEY-024', 'Experimente o terror cooperativo em uma instalação experimental.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/1304930/header.jpg', 0),
(72, 'Rainbow Six Siege', 89.90, 9, 'R6S-STEAM-KEY-026', 'FPS tático com foco em estratégia e trabalho em equipe.', '2025-10-29 23:15:51', 'https://cdn.akamai.steamstatic.com/steam/apps/359550/header.jpg', 0),
(74, 'Marvel’s Spider-Man Remastered', 249.90, 1, 'SPIDERMAN-STEAM-001', 'Balance-se por Nova York com o Homem-Aranha em uma história emocionante e cheia de ação.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1817070/header.jpg', 0),
(75, 'Watch Dogs: Legion', 99.90, 1, 'WDL-STEAM-002', 'Monte sua resistência em uma Londres futurista e lute contra um sistema opressor.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/2239550/header.jpg', 0),
(76, 'Mad Max', 59.90, 1, 'MMAX-STEAM-003', 'Sobreviva em um mundo pós-apocalíptico dominado por gangues e deserto.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/234140/header.jpg', 0),
(77, 'The Witcher 3: Wild Hunt', 99.90, 2, 'TW3-STEAM-004', 'Viva como Geralt de Rívia em um dos maiores RPGs já criados.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/292030/header.jpg', 0),
(78, 'Elden Ring', 249.90, 2, 'ELDENRING-STEAM-005', 'Explore as Terras Intermédias neste épico de mundo aberto e combate desafiador.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1245620/header.jpg', 0),
(79, 'Starfield', 349.90, 2, 'STARFIELD-STEAM-006', 'Um RPG espacial da Bethesda com centenas de planetas e liberdade total.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1716740/header.jpg', 0),
(80, 'Slay the Spire', 49.90, 3, 'STS-STEAM-007', 'Construa seu baralho e lute em batalhas estratégicas neste roguelike aclamado.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/646570/header.jpg', 0),
(81, 'The Binding of Isaac: Rebirth', 34.90, 3, 'ISAAC-STEAM-008', 'Um roguelike sombrio e viciante cheio de segredos e bizarrices.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/250900/header.jpg', 0),
(82, 'Dead Cells', 79.90, 3, 'DCELLS-STEAM-009', 'Ação fluida e desafios constantes em um metroidvania roguelike.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/588650/header.jpg', 0),
(83, 'Dying Light', 349.90, 4, 'ZELDA-TOK-STEAM-010', 'Explore o reino de Hyrule em uma aventura inesquecível cheia de liberdade.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/239140/header.jpg', 0),
(84, 'Detroit: Become Human', 159.90, 4, 'DETROIT-STEAM-011', 'Decisões morais e narrativa profunda em um futuro com androides conscientes.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1222140/header.jpg', 0),
(85, 'A Plague Tale: Requiem', 229.90, 4, 'PLAGUE-STEAM-012', 'Uma história comovente de sobrevivência e sacrifício em tempos sombrios.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1182900/header.jpg', 0),
(87, 'Assetto Corsa Competizione', 139.90, 5, 'ACC-STEAM-014', 'Simulador oficial do GT World Challenge, com física e som realistas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/805550/header.jpg', 0),
(88, 'Wreckfest', 89.90, 5, 'WRFST-STEAM-015', 'Corridas destrutivas com colisões realistas e muita diversão.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/228380/header.jpg', 0),
(89, 'Guilty Gear Strive', 229.90, 6, 'GGS-STEAM-016', 'Visual impressionante e trilha sonora eletrizante neste jogo de luta aclamado.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1384160/header.jpg', 0),
(90, 'Dragon Ball FighterZ', 139.90, 6, 'DBFZ-STEAM-017', 'Combates intensos com personagens icônicos de Dragon Ball Z.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/678950/header.jpg', 0),
(91, 'Injustice 2', 79.90, 6, 'INJ2-STEAM-018', 'Super-heróis e vilões da DC lutam em batalhas épicas cheias de poder.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/627270/header.jpg', 0),
(92, 'Super Meat Boy', 29.90, 7, 'SMB-STEAM-019', 'Desafios insanos e reflexos rápidos neste clássico de plataforma.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/40800/header.jpg', 0),
(93, 'Little Nightmares II', 99.90, 7, 'LN2-STEAM-020', 'Um pesadelo sombrio e misterioso em um mundo de infância distorcido.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/860510/header.jpg', 0),
(94, 'It Takes Two', 149.90, 7, 'ITT-STEAM-021', 'Uma aventura cooperativa criativa e divertida sobre união e superação.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1426210/header.jpg', 0),
(95, 'Resident Evil Village', 179.90, 8, 'REVILLAGE-STEAM-022', 'Explore uma vila macabra cheia de segredos e criaturas grotescas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1455840/header.jpg', 0),
(96, 'Phasmophobia', 49.90, 8, 'PHASMO-STEAM-023', 'Caça fantasmas cooperativo com terror psicológico e realismo.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/739630/header.jpg', 0),
(97, 'The Medium', 129.90, 8, 'MEDIUM-STEAM-024', 'Um suspense psicológico com mundos paralelos e atmosfera intensa.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1293160/header.jpg', 0),
(98, 'DOOM Eternal', 179.90, 9, 'DOOME-STEAM-025', 'Ação frenética e brutal em um dos FPS mais intensos já feitos.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/782330/header.jpg', 0),
(99, 'Battlefield 2042', 199.90, 9, 'BF2042-STEAM-026', 'Combates massivos em campos de batalha futuristas.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/1517290/header.jpg', 0),
(100, 'Far Cry 6', 179.90, 9, 'FC6-STEAM-027', 'Lute contra um regime ditatorial em uma ilha tropical.', '2025-10-29 23:21:02', 'https://cdn.akamai.steamstatic.com/steam/apps/2369390/header.jpg', 0),
(101, 'Titanfall 2', 59.90, 1, 'TF2-KEY-001', 'Shooter de ação rápida com história e multiplayer inovador.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/1237970/header.jpg', 0),
(102, 'Middle-earth: Shadow of War', 49.90, 1, 'SOW-KEY-002', 'Ação em mundo aberto na Terra‐Média, com sistema de nemesis profundo.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/356190/header.jpg', 0),
(103, 'Just Cause 3', 39.90, 1, 'JC3-KEY-003', 'Explosões, paraquedas e caos em uma ilha enorme de jogo de ação pura.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/387290/header.jpg', 0),
(104, 'Pillars of Eternity II: Deadfire', 89.90, 2, 'POE2-KEY-004', 'RPG isométrico profundo com narrativa e escolha moral.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/560130/header.jpg', 0),
(105, 'Divinity: Original Sin 2', 99.90, 2, 'DOS2-KEY-005', 'RPG tático premiado com cooperação e liberdade total.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/435150/header.jpg', 0),
(106, 'Wasteland 3', 79.90, 2, 'WL3-KEY-006', 'RPG pós‐apocalíptico com combates táticos e escolhas difíceis.', '2025-10-30 01:27:49', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1642320/header.jpg?t=1673998440', 0),
(107, 'Undertale', 29.90, 3, 'UT-KEY-007', 'RPG/aventura indie popular com humor e escolhas impactantes.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/391540/header.jpg', 0),
(109, 'Hollow Knight', 49.90, 3, 'HK-KEY-009', 'Metroidvania indie lindo, enorme e cheio de segredos.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/413420/header.jpg', 0),
(110, 'The Walking Dead: The Telltale Series', 39.90, 4, 'TWDTS-KEY-010', 'Aventura narrativa emocional baseada na série de TV.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/207610/header.jpg', 0),
(111, 'Life is Strange', 49.90, 4, 'LIS-KEY-011', 'Uma aventura episódica sobre poderes, escolhas e consequências.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/319630/header.jpg', 0),
(112, 'Firewatch', 59.90, 4, 'FW-KEY-012', 'Aventura em primeira pessoa com história emocional e visual marcante.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/383870/header.jpg', 0),
(114, 'Burnout Paradise Remastered', 79.90, 5, 'BPR-KEY-014', 'Corrida arcade explosiva em cidade aberta.', '2025-10-30 01:27:49', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1238080/header.jpg?t=1625518920', 0),
(116, 'Marvel vs. Capcom: Infinite', 119.90, 6, 'MVCI-KEY-016', 'Luta frenética entre heróis da Marvel e da Capcom.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/678950/header.jpg', 0),
(117, 'Tekken 7', 109.90, 6, 'TK7-KEY-017', 'Luta 3D de altíssimo nível com elenco clássico.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/389730/header.jpg', 0),
(118, 'Soulcalibur VI', 99.90, 6, 'SC6-KEY-018', 'Luta de armas e estilo em arenas grandiosas.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/544750/header.jpg', 0),
(119, 'Ori and the Blind Forest: Definitive Edition', 59.90, 7, 'OOTS-KEY-019', 'Plataforma encantador com arte maravilhosa e desafios leves.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/387290/header.jpg', 0),
(121, 'Super Meat Boy Forever', 39.90, 7, 'SMBF-KEY-021', 'Plataforma rápido e difícil, continuação do clássico Meat Boy.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/668580/header.jpg', 0),
(122, 'Amnesia: The Dark Descent', 39.90, 8, 'AMN-KEY-022', 'Terror psicológico assustador em mansão escura.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/57300/header.jpg', 0),
(123, 'Alien: Isolation', 89.90, 8, 'AI-KEY-023', 'Terror de sobrevivência espacial com alienígena implacável.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/214490/header.jpg', 0),
(124, 'The Evil Within', 79.90, 8, 'TEW-KEY-024', 'Terror de sobrevivência com ação sombria e tensão constante.', '2025-10-30 01:27:49', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/268050/header.jpg?t=1750783780', 0),
(126, 'Bioshock Infinite', 59.90, 9, 'BI-KEY-026', 'FPS com narrativa rica e cenários impressionantes.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/8870/header.jpg', 0),
(127, 'Wolfenstein II: The New Colossus', 69.90, 9, 'WC2-KEY-027', 'FPS explosivo com história alternativa e muita ação.', '2025-10-30 01:27:49', 'https://cdn.akamai.steamstatic.com/steam/apps/582500/header.jpg', 0),
(128, 'Dishonored 2', 99.90, 1, 'D2-KEY-001', 'Ação furtiva e poderes sobrenaturais em uma aventura sombria e estilosa.', '2025-11-11 01:11:46', 'https://cdn.akamai.steamstatic.com/steam/apps/403640/header.jpg', 0),
(129, 'Nioh 2', 149.90, 1, 'NIOH2-KEY-002', 'Ação RPG desafiadora inspirada no Japão feudal com combate profundo.', '2025-11-11 01:11:46', 'https://cdn.akamai.steamstatic.com/steam/apps/1325200/header.jpg', 0),
(130, 'Mad Max (2015)', 59.90, 1, 'MMAX15-KEY-003', 'Ação em mundo aberto com combates veiculares e exploração no deserto.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/234140/header.jpg?t=1732555043', 0),
(131, 'Shadow of the Tomb Raider', 129.90, 1, 'SOTTR-KEY-004', 'Ação e aventura com Lara em ambientes exóticos e desafios mortais.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/750920/header.jpg?t=1729014037', 0),
(132, 'Watch Dogs 2', 89.90, 1, 'WD2-KEY-005', 'Ação tech em mundo aberto com hack e muita liberdade.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/447040/header.jpg?t=1751986887', 0),
(133, 'Kingdom Come: Deliverance', 99.90, 2, 'KCD-KEY-006', 'RPG realista ambientado na Boêmia medieval, com combate histórico.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/379430/header.jpg?t=1762938039', 0),
(134, 'Persona 5 Strikers', 179.90, 2, 'P5S-KEY-007', 'Ação/RPG com estilo anime, combates de grupo e história cativante.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1382330/header.jpg?t=1762544873', 0),
(136, 'GreedFall', 79.90, 2, 'GF-KEY-009', 'RPG de ação/aventura com exploração, diplomacia e combate tático.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/606880/header.jpg?t=1727794180', 0),
(137, 'Monster Hunter: World', 169.90, 2, 'MHW-KEY-010', 'Caça cooperativa a monstros com armas e armaduras customizáveis.', '2025-11-11 01:11:46', 'https://cdn.akamai.steamstatic.com/steam/apps/582010/header.jpg', 0),
(139, 'Katana ZERO', 49.90, 3, 'KZ-KEY-012', 'Indie rápido com ação de precisão, tempo e narrativa cortante.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/460950/header.jpg?t=1761066027', 0),
(140, 'Return of the Obra Dinn', 79.90, 3, 'OBRA-KEY-013', 'Investigação lógica única com estética monocromática e narrativa genial.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/653530/header.jpg?t=1686697594', 0),
(141, 'Gris', 29.90, 3, 'GRIS-KEY-014', 'Plataforma/puzzle poético com arte linda e trilha delicada.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/683320/header.jpg?t=1759429603', 0),
(142, 'TowerFall Ascension', 19.90, 3, 'TF-KEY-015', 'Multiplayer local indie viciante de arco e flecha e caos.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/251470/header.jpg?t=1715114308', 0),
(143, 'Inside', 39.90, 4, 'INSIDE-KEY-016', 'Aventura/puzzle sombria e atmosférica dos criadores de Limbo.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/304430/header.jpg?t=1761819581', 0),
(144, 'Grim Fandango Remastered', 49.90, 4, 'GF-KEY-017', 'Aventura clássica com humor noir e personagens inesquecíveis.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/316790/header.jpg?t=1731602112', 0),
(145, 'Sekiro: Shadows Die Twice (história modo)', 179.90, 4, 'SEKIRO-KEY-018', 'A aventura/samurai tensa com foco em habilidade e precisão.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/814380/header.jpg?t=1762888662', 0),
(146, 'The Long Dark', 69.90, 4, 'TLD-KEY-019', 'Aventura de sobrevivência contemplativa nas montanhas geladas.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/305620/header.jpg?t=1745525398', 0),
(147, 'Outer Wilds', 119.90, 4, 'OW-KEY-020', 'Exploração espacial e quebra-cabeças em loop temporal intrigante.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/753640/header.jpg?t=1729097431', 0),
(148, 'TrackMania (2020)', 49.90, 5, 'TM-KEY-021', 'Corrida arcade focada em tempo, criação de pistas e comunidade.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2225070/header.jpg?t=1751554575', 0),
(149, 'Project CARS 2', 129.90, 5, 'PCARS2-KEY-022', 'Simulador de corridas com física e condições dinâmicas realistas.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/860233/header.jpg?t=1727978347', 0),
(150, 'MotoGP 22', 199.90, 5, 'MGP22-KEY-023', 'Simulação de moto com pilotos e pistas oficiais.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1710580/header.jpg?t=1728470115', 0),
(151, 'WRC 10', 149.90, 5, 'WRC10-KEY-024', 'Rally oficial com carros e estágios históricos.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1462810/header.jpg?t=1725353913', 0),
(152, 'F1 23', 299.90, 5, 'F123-KEY-025', 'Simulação Formula 1 moderna com campeonatos e modos carreira.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2287220/header.jpg?t=1728992590', 0),
(153, 'Virtua Fighter 5', 69.90, 6, 'VF5-KEY-026', 'Clássico da luta 3D com técnica e frames reais.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/3419320/header.jpg?t=1761751442', 0),
(157, 'Samurai Shodown (2019)', 99.90, 6, 'SS-KEY-030', 'Luta de armas com foco em precisão e momentum.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1342260/header.jpg?t=1718092533', 0),
(158, 'Braid', 39.90, 7, 'BRAID-KEY-031', 'Plataforma/puzzle que reinventou o gênero indie com manipulação do tempo.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/26800/header.jpg?t=1734027955', 0),
(159, 'Shovel Knight: Treasure Trove', 59.90, 7, 'SK-KEY-032', 'Homenagem aos clássicos de 8-bit com design moderno.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/250760/header.jpg?t=1723577994', 0),
(160, 'A Hat in Time', 79.90, 7, 'AHIT-KEY-033', 'Plataforma 3D charmosa inspirada em clássicos como Mario.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/253230/header.jpg?t=1737595291', 0),
(162, 'Mark of the Ninja', 69.90, 7, 'MOTN-KEY-035', 'Plataforma/stealth com animação fluida e design preciso.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/214560/header.jpg?t=1668892924', 0),
(163, 'Soma', 49.90, 8, 'SOMA-KEY-036', 'Terror sci-fi filosófico com atmosfera opressiva e história profunda.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/282140/header.jpg?t=1752056335', 0),
(164, 'Layers of Fear', 39.90, 8, 'LOF-KEY-037', 'Terror psicológico focado em exploração e medo crescente.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1946700/header.jpg?t=1761589628', 0),
(167, 'Visage', 59.90, 8, 'VIS-KEY-040', 'Terror psicológico lento e claustrofóbico, pura tensão.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/594330/header.jpg?t=1607559678', 0),
(168, 'Metro Exodus', 129.90, 9, 'METRO-KEY-041', 'FPS com atmosfera pós-apocalíptica e cenários enormes.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/412020/header.jpg?t=1750772804', 0),
(169, 'Far Cry 5', 129.90, 9, 'FC5-KEY-042', 'FPS em mundo aberto com ação, veículos e vilões carismáticos.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/552520/header.jpg?t=1762190084', 0),
(170, 'Borderlands 3', 149.90, 9, 'BL3-KEY-043', 'FPS-looter com humor, armas infinitas e co-op frenético.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/397540/header.jpg?t=1750802377', 0),
(171, 'Call of Duty: Black Ops Cold War', 199.90, 9, 'BOCW-KEY-044', 'FPS moderno com campanha e multiplayer competitivo.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1985810/header.jpg?t=1731607699', 0),
(172, 'Planetside 2', 0.00, 9, 'PS2-KEY-045', 'FPS massivo online com batalhas gigantescas entre facções.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/218240/header.jpg?t=1623780515', 0),
(173, 'Hitman 3', 129.90, 1, 'HIT3-KEY-046', 'Ação furtiva e sandbox onde criatividade mata melhor que força.', '2025-11-11 01:11:46', 'https://cdn.akamai.steamstatic.com/steam/apps/1174180/header.jpg', 0),
(174, 'Horizon Zero Dawn', 169.90, 2, 'HZD-KEY-047', 'RPG de ação com mundo pós-apocalíptico e máquinas gigantescas.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2561580/header.jpg?t=1750952943', 0),
(175, 'FEZ', 29.90, 3, 'FEZ-KEY-048', 'Indie de puzzle/plataforma com giro dimensional e charme.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/224760/header.jpg?t=1572375251', 0),
(176, 'The Cat Lady', 19.90, 4, 'CATLADY-KEY-049', 'Aventura narrativa sombria para públicos maduros.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/253110/header.jpg?t=1762784299', 0),
(177, 'Hot Wheels Unleashed', 89.90, 5, 'HWU-KEY-050', 'Corrida arcade com pistas malucas e personalização de carros.', '2025-11-11 01:11:46', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1271700/header.jpg?t=1725035139', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_venda` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'kevin', 'kevin@gmail.com', '$2y$10$FIiFjAaTob/ITvwsTpRSG.bNb084W9LBRyEncZmYtSeLa3438myuW', '2025-10-29 22:52:24', 'admin'),
(4, 'kevin', 'kevin.h.nogueira@gmail.com', '$2y$10$t5CvAW60QgY7jwHdaFWexOtw9MX8lDh7rcMdg0Hzw.XZ9OmHX9zxW', '2025-11-10 22:31:31', 'user'),
(5, 'Anderson Burnes', 'kevin.h.burnes@gmail.com', '$2y$10$IbuzRBJBeb688zhMU7Bl6.cAIyeX.Zqzb9XbdCPBaOpPmwX.0z9iy', '2025-11-11 01:36:55', 'user'),
(6, 'kevin', 'kevinenrique@gmail.com', '$2y$10$ZH59tYQMvPqE6kKUYHlvT.3sykZB3MDGun5q1pvcoancG4361Kp/y', '2025-11-13 22:29:45', 'user'),
(7, 'jorge', 'jorge@gmail.com', '$2y$10$aKhyze/XGnUCJJgLfMMqeO/qo0RNg7TIq0prb3Ueffl7tF14Sq2wm', '2025-11-14 00:43:14', 'user');

-- --------------------------------------------------------

--
-- Estrutura para tabela `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `jogo_id` int(11) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `wishlist`
--

INSERT INTO `wishlist` (`id`, `usuario_id`, `jogo_id`, `data_criacao`) VALUES
(3, 4, 123, '2025-11-10 22:46:21'),
(4, 4, 114, '2025-11-10 22:46:54'),
(8, 4, 67, '2025-11-11 01:00:13'),
(11, 4, 54, '2025-11-11 22:35:03'),
(22, 3, 85, '2025-11-13 23:53:24'),
(23, 3, 160, '2025-11-13 23:53:28'),
(24, 3, 99, '2025-11-14 00:54:44'),
(26, 2, 158, '2025-11-17 22:44:54'),
(27, 2, 94, '2025-11-17 22:57:45');

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
-- Índices de tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`usuario_id`,`jogo_id`),
  ADD KEY `jogo_id` (`jogo_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

--
-- Restrições para tabelas `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`jogo_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
