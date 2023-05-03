-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 03-Maio-2023 às 02:37
-- Versão do servidor: 8.0.27
-- versão do PHP: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_torcida`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos`
--

DROP TABLE IF EXISTS `cargos`;
CREATE TABLE IF NOT EXISTS `cargos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idInstituicao` int NOT NULL,
  `nome` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cargos`
--

INSERT INTO `cargos` (`id`, `idInstituicao`, `nome`) VALUES
(1, 1, 'Diretor'),
(2, 1, 'Presidente'),
(3, 1, 'Baterista'),
(4, 1, 'Membro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargosmembro`
--

DROP TABLE IF EXISTS `cargosmembro`;
CREATE TABLE IF NOT EXISTS `cargosmembro` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idMembro` int NOT NULL,
  `nomeCargo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `cargosmembro`
--

INSERT INTO `cargosmembro` (`id`, `idMembro`, `nomeCargo`) VALUES
(81, 4, 'Baterista'),
(80, 4, 'Diretor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contatomembros`
--

DROP TABLE IF EXISTS `contatomembros`;
CREATE TABLE IF NOT EXISTS `contatomembros` (
  `id` int NOT NULL,
  `idTorcedor` int NOT NULL,
  `contato` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

DROP TABLE IF EXISTS `endereco`;
CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int NOT NULL,
  `idTorcedor` int NOT NULL,
  `cep` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `enderecoCompleto` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupomembros`
--

DROP TABLE IF EXISTS `grupomembros`;
CREATE TABLE IF NOT EXISTS `grupomembros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idMembro` int NOT NULL,
  `nomeGrupo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `grupomembros`
--

INSERT INTO `grupomembros` (`id`, `idMembro`, `nomeGrupo`) VALUES
(41, 4, 'Conexão R3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE IF NOT EXISTS `grupos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idInstituicao` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sigla` varchar(30) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `idInstituicao`, `nome`, `sigla`, `status`) VALUES
(18, 1, 'Conexão R3', 'R3', 0),
(17, 1, 'Bonde Riacho', 'BDR', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao`
--

DROP TABLE IF EXISTS `instituicao`;
CREATE TABLE IF NOT EXISTS `instituicao` (
  `id` int NOT NULL,
  `idPresidente` int NOT NULL,
  `nomeInstituicao` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sigla` varchar(30) NOT NULL,
  `data` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `instituicao`
--

INSERT INTO `instituicao` (`id`, `idPresidente`, `nomeInstituicao`, `sigla`, `data`) VALUES
(1, 1, 'IRA JOVEM DO GAMA', 'IJG', ''),
(2, 2, 'FORÇA TESTE', 'TFT', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `membros`
--

DROP TABLE IF EXISTS `membros`;
CREATE TABLE IF NOT EXISTS `membros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hash` text NOT NULL,
  `imagem` text NOT NULL,
  `idInstituicao` int NOT NULL,
  `nomeMembro` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `paiMembro` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `maeMembro` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cpfMembro` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dataMembro` date NOT NULL,
  `dataCadastro` date NOT NULL,
  `profissaoMembro` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `emailMembro` varchar(120) NOT NULL,
  `contatoMembro` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senhaMembro` varchar(120) NOT NULL,
  `acesso` int NOT NULL,
  `socio` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `membros`
--

INSERT INTO `membros` (`id`, `hash`, `imagem`, `idInstituicao`, `nomeMembro`, `paiMembro`, `maeMembro`, `cpfMembro`, `dataMembro`, `dataCadastro`, `profissaoMembro`, `emailMembro`, `contatoMembro`, `senhaMembro`, `acesso`, `socio`, `status`) VALUES
(4, '49ff6328e01be157e3443dbd2c12d5ac', 'e105faa4a90f1bb956647a9d51fc5dba.png', 1, 'samuel de sousa campos', 'lindomar carvalho campos', 'adriana dias ', '05962967119', '2023-05-02', '0000-00-00', 'militar', 'samukadesousa2014@gmail.com', '', '', 1, '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `codigo` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `usuario`, `codigo`) VALUES
(1, 'samukadesousa2014@gmail.com', '96385274', '05962967119', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
