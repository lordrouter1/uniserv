-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 23/06/2020 às 13:59
-- Versão do servidor: 10.3.22-MariaDB-0+deb10u1
-- Versão do PHP: 5.6.40-29+0~20200514.35+debian9~1.gbpcc49a4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `data_uniserve`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_clientes`
--

CREATE TABLE `tbl_clientes` (
  `id` int(11) NOT NULL,
  `tipoPessoa` varchar(2) NOT NULL COMMENT 'PJ / PF',
  `razaoSocial_nome` varchar(120) NOT NULL,
  `cnpj_cpf` varchar(18) NOT NULL,
  `nomeResponsavel` varchar(120) NOT NULL,
  `logradouro` varchar(120) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `complemento` varchar(120) NOT NULL,
  `bairro` varchar(120) NOT NULL,
  `cidade` varchar(80) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `email` varchar(120) NOT NULL,
  `telefoneEmpresa` varchar(16) NOT NULL,
  `telefoneWhatsapp` varchar(16) NOT NULL,
  `cpfResponsavel` varchar(15) NOT NULL,
  `observacao` text NOT NULL,
  `estado` varchar(2) NOT NULL,
  `tipoCliente` varchar(5) NOT NULL,
  `tipoFornecedor` varchar(5) NOT NULL,
  `tipoFuncionario` varchar(5) NOT NULL,
  `tipoTecnico` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tbl_clientes`
--

INSERT INTO `tbl_clientes` (`id`, `tipoPessoa`, `razaoSocial_nome`, `cnpj_cpf`, `nomeResponsavel`, `logradouro`, `numero`, `complemento`, `bairro`, `cidade`, `cep`, `email`, `telefoneEmpresa`, `telefoneWhatsapp`, `cpfResponsavel`, `observacao`, `estado`, `tipoCliente`, `tipoFornecedor`, `tipoFuncionario`, `tipoTecnico`) VALUES
(4, 'PF', 'cliente', '02694062040', 'andre gigghi', 'rua marechal floriano', '1380', 'sala 01', 'planalto', 'Guaporé', '99200-000', 'juliobenin@yahoo.com.br', '(54) 99999-9999', '(54) 99999-9999', '000.000.000-00', '', 'RS', 'on', '', '', ''),
(5, 'PF', 'fornecedor', '02694062040', 'andre gigghi', 'rua marechal floriano', '1380', 'sala 01', 'planalto', 'Guaporé', '99200-000', 'juliobenin@yahoo.com.br', '(54) 99999-9999', '(54) 99999-9999', '000.000.000-00', '', 'RS', '', 'on', '', ''),
(6, 'PF', 'cliente e fornecedor', '02694062040', 'andre gigghi', 'rua marechal floriano', '1380', 'sala 01', 'planalto', 'Guaporé', '99200-000', 'juliobenin@yahoo.com.br', '(54) 99999-9999', '(54) 99999-9999', '000.000.000-00', '', 'RS', 'on', 'on', '', ''),
(7, 'PF', 'tecnico', '02694062040', 'andre gigghi', 'rua marechal floriano', '1380', 'sala 01', 'planalto', 'Guaporé', '99200-000', 'juliobenin@yahoo.com.br', '(54) 99999-9999', '(54) 99999-9999', '000.000.000-00', '', 'RS', '', '', 'on', 'on'),
(8, 'PF', 'cliente, fornecedor, funcionario e técnico', '02694062040', 'andre gigghi', 'rua marechal floriano', '1380', 'sala 01', 'planalto', 'Guaporé', '99200-000', 'juliobenin@yahoo.com.br', '(54) 99999-9999', '(54) 99999-9999', '000.000.000-00', '', 'RS', 'on', 'on', 'on', 'on');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_clienteServicos`
--

CREATE TABLE `tbl_clienteServicos` (
  `id` int(11) NOT NULL,
  `servico` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tbl_clienteServicos`
--

INSERT INTO `tbl_clienteServicos` (`id`, `servico`, `cliente`, `valor`) VALUES
(1, 3, 8, '13.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_contratos`
--

CREATE TABLE `tbl_contratos` (
  `id` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `dataInicial` date NOT NULL,
  `dataFinal` date NOT NULL,
  `diaVencimento` int(11) NOT NULL,
  `primeiroVencimento` date NOT NULL,
  `duracao` int(11) NOT NULL COMMENT 'em mêses',
  `status` int(11) NOT NULL COMMENT '1 = assinar, 2 = em vigência e 3 = encerrado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tbl_contratos`
--

INSERT INTO `tbl_contratos` (`id`, `cliente`, `dataInicial`, `dataFinal`, `diaVencimento`, `primeiroVencimento`, `duracao`, `status`) VALUES
(9, 4, '2020-06-23', '2020-10-23', 23, '2020-06-23', 4, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_contratosServicos`
--

CREATE TABLE `tbl_contratosServicos` (
  `id` int(11) NOT NULL,
  `servicos` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `contrato` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tbl_contratosServicos`
--

INSERT INTO `tbl_contratosServicos` (`id`, `servicos`, `valor`, `contrato`) VALUES
(3, 2, '12.00', 9),
(4, 3, '12.00', 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_servicos`
--

CREATE TABLE `tbl_servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `descricao` varchar(400) NOT NULL,
  `valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Fazendo dump de dados para tabela `tbl_servicos`
--

INSERT INTO `tbl_servicos` (`id`, `nome`, `descricao`, `valor`) VALUES
(2, 'formatação2', 'formatação de computadores', '0.00'),
(3, 'instalação debian', 'instalação do sistema operacional debian', '0.00'),
(4, 'formatação windows', 'formatação de sistema operacional', '0.00'),
(5, 'serviço de teste', 'teste', '12.00');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_clienteServicos`
--
ALTER TABLE `tbl_clienteServicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_contratos`
--
ALTER TABLE `tbl_contratos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_contratosServicos`
--
ALTER TABLE `tbl_contratosServicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tbl_servicos`
--
ALTER TABLE `tbl_servicos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tbl_clientes`
--
ALTER TABLE `tbl_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de tabela `tbl_clienteServicos`
--
ALTER TABLE `tbl_clienteServicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de tabela `tbl_contratos`
--
ALTER TABLE `tbl_contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `tbl_contratosServicos`
--
ALTER TABLE `tbl_contratosServicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `tbl_servicos`
--
ALTER TABLE `tbl_servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
