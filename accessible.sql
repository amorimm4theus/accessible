-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Nov-2024 às 02:50
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `accessible`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acessibilidades`
--

CREATE TABLE `acessibilidades` (
  `id` int(11) NOT NULL,
  `acessibilidade` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `acessibilidades`
--

INSERT INTO `acessibilidades` (`id`, `acessibilidade`) VALUES
(1, 'Elevador acessível'),
(2, 'Piso tátil'),
(3, 'Guia em Libras'),
(4, 'Cadeira de rodas disponível'),
(5, 'Rampa de acesso'),
(6, 'Porta automática'),
(7, 'Corrimão duplo'),
(8, 'Sinalização em braille'),
(9, 'Áudio-descrição'),
(10, 'Banheiro adaptado'),
(11, 'Vagas de estacionamento reservadas'),
(12, 'Mapas táteis'),
(13, 'Aviso sonoro em elevadores'),
(14, 'Sinalização visual clara'),
(15, 'Atendimento prioritário'),
(16, 'Mesas adaptadas'),
(17, 'Balcões rebaixados'),
(18, 'Cardápio em braille'),
(19, 'Assentos preferenciais'),
(20, 'Serviço de guia para deficientes visuais'),
(21, 'Interpretação simultânea em eventos'),
(22, 'Rotas acessíveis'),
(23, 'Sensores de movimento para iluminação'),
(24, 'Aplicativos de orientação acessíveis'),
(25, 'Letreiros em letras grandes'),
(26, 'Telefone adaptado (TDD)'),
(27, 'Serviço de audioguia'),
(28, 'Alarme visual para deficientes auditivos'),
(29, 'Letreiro eletrônico para surdos'),
(30, 'Acesso para cães-guia'),
(31, 'Sistema de loop de indução (para deficientes auditivos)'),
(32, 'Pisos antiderrapantes'),
(33, 'Espaço reservado para cadeiras de rodas'),
(34, 'Entrada nivelada'),
(35, 'Aviso de degraus com cores de contraste'),
(36, 'Apoio para muletas e bengalas'),
(37, 'Assento ergonômico'),
(38, 'Rodapé em cor de contraste'),
(39, 'Controle remoto para chamada de elevador'),
(40, 'Assentos com apoio para braços'),
(41, 'Fontes grandes nos documentos impressos'),
(42, 'Serviço de transporte acessível'),
(43, 'Intérprete de Libras virtual'),
(44, 'Assentos com cintos de segurança'),
(45, 'Escadas rolantes com sinalização em braille'),
(46, 'Área de descanso acessível'),
(47, 'Cartões de atendimento em Libras'),
(48, 'Sinalização para baixa visão'),
(49, 'Câmeras de vigilância em áreas acessíveis'),
(50, 'Wi-Fi acessível (para comunicação e navegação assistiva)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `acessibilidades_locais`
--

CREATE TABLE `acessibilidades_locais` (
  `id` int(11) NOT NULL,
  `acessibilidade_id` int(11) NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE `cidade` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) DEFAULT NULL,
  `uf` int(2) DEFAULT NULL,
  `ibge` int(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Municipios das Unidades Federativas';

-- --------------------------------------------------------

--
-- Estrutura da tabela `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `nome` varchar(75) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `ibge` int(2) DEFAULT NULL,
  `pais` int(3) DEFAULT NULL,
  `ddd` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Unidades Federativas';

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais`
--

CREATE TABLE `locais` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cep` varchar(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cidade_id` int(11) NOT NULL,
  `id_usuario_cadastrou` int(11) NOT NULL,
  `latitude` decimal(11,9) DEFAULT NULL,
  `longitude` decimal(11,9) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cidade_id` int(11) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `sessao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `acessibilidades`
--
ALTER TABLE `acessibilidades`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `acessibilidades_locais`
--
ALTER TABLE `acessibilidades_locais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cidade`
--
ALTER TABLE `cidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessibilidades`
--
ALTER TABLE `acessibilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `acessibilidades_locais`
--
ALTER TABLE `acessibilidades_locais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `locais`
--
ALTER TABLE `locais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
