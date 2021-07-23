-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04-Dez-2019 às 13:21
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_exetasks`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID da atividade.',
  `nome` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Nome da atividade.',
  `descricao` text COLLATE utf8_bin NOT NULL COMMENT 'Descrição da atividade.',
  `prazo` datetime NOT NULL COMMENT 'Prazo de entrega da atividade.',
  `experiencia` int(11) NOT NULL COMMENT 'Pontos de experiência que a atividade concede quando for concluida.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar todas as atividades do sistema.';

--
-- Extraindo dados da tabela `atividades`
--

INSERT INTO `atividades` (`id`, `nome`, `descricao`, `prazo`, `experiencia`) VALUES
(0000000002, 'Apresentar trabalho ', 'Apresentação do trabalho final', '2019-12-04 12:00:00', 30),
(0000000003, 'Arrumar Rodapé', 'Arrumar rodapé do sistema ExeTasks', '2019-12-04 12:00:00', 100),
(0000000004, 'Modais dinamicos', 'Modais de alteração', '2019-12-04 20:20:00', 30),
(0000000005, 'Corrigir Atividades', 'Corrigir atividades da turma que foi esquecida por Deus', '2019-12-20 00:00:00', 100),
(0000000006, 'Apresentar trabalho ', 'Apresentar trabalho final de desenvolvimento de sistemas', '2019-12-04 12:00:00', 30),
(0000000007, 'Back-End', 'Concluir back-end página index', '2019-12-04 12:00:00', 10),
(0000000008, 'Ensino Médio', 'Concluir ensino médio', '2020-01-01 00:00:00', 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do grupo.',
  `nome` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Nome do grupo.',
  `descricao` text COLLATE utf8_bin NOT NULL COMMENT 'Descrição do grupo.',
  `foto` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'URL da foto do grupo.',
  `status` tinyint(1) NOT NULL COMMENT 'Status do grupo para verificar se o mesmo está ativo ou inativo.',
  `interesses_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do interesse que o grupo possui.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar todos os grupos do sistema.';

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `nome`, `descricao`, `foto`, `status`, `interesses_id`) VALUES
(0000000001, 'DEVSIS 2019 ExeTasks', 'Grupo do ExeTasks para atividades do trabalho final', '', 1, 0000000009),
(0000000002, 'DEVSIS 2019 FAM', 'Grupo do FAM para atividades do trabalho final', '', 1, 0000000009);

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos_has_atividades`
--

CREATE TABLE `grupos_has_atividades` (
  `grupos_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do grupo que possui atividades.',
  `atividades_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID das atividades que os grupos possuem.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar todas as atividades dos grupos.';

--
-- Extraindo dados da tabela `grupos_has_atividades`
--

INSERT INTO `grupos_has_atividades` (`grupos_id`, `atividades_id`) VALUES
(0000000001, 0000000002),
(0000000001, 0000000003),
(0000000001, 0000000004),
(0000000002, 0000000006),
(0000000002, 0000000007);

-- --------------------------------------------------------

--
-- Estrutura da tabela `interesses`
--

CREATE TABLE `interesses` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do interesse.',
  `nome` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Nome do interesse.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar os interesses do sistema.';

--
-- Extraindo dados da tabela `interesses`
--

INSERT INTO `interesses` (`id`, `nome`) VALUES
(0000000001, 'Matemática'),
(0000000002, 'Português'),
(0000000003, 'Química'),
(0000000004, 'Física'),
(0000000005, 'Geografia'),
(0000000006, 'Biologia'),
(0000000007, 'Filosofia'),
(0000000008, 'Idiomas'),
(0000000009, 'Informática'),
(0000000010, 'Engenharia'),
(0000000011, 'Música'),
(0000000012, 'História'),
(0000000013, 'Outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário.',
  `nome` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Nome do usuário.',
  `usuario` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Apelido do usuário.',
  `senha` char(32) COLLATE utf8_bin NOT NULL COMMENT 'Senha do usuário.',
  `email` varchar(40) COLLATE utf8_bin NOT NULL COMMENT 'E-mail do usuário.',
  `data_nasc` date NOT NULL COMMENT 'Data de nascimento do usuário.',
  `sexo` char(1) COLLATE utf8_bin NOT NULL COMMENT 'Sexo do usuário.',
  `tipo` char(1) COLLATE utf8_bin NOT NULL COMMENT 'Serve para determinar se o usuário é professor ou estudante.',
  `nivel` int(11) NOT NULL COMMENT 'Nível do usuário.',
  `experiencia` int(11) NOT NULL COMMENT 'Total de experiência que o usuário possui.',
  `foto` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'Avatar do usuário.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar usuários do sistema.';

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `email`, `data_nasc`, `sexo`, `tipo`, `nivel`, `experiencia`, `foto`) VALUES
(0000000001, 'Fernando Ribeiro', 'finnc', 'b941e56cf3927b1f65ec1626a98e1a59', 'fernando_a_ribeiro@estudante.sc.senai.br', '1998-07-27', 'M', 'E', 0, 0, ''),
(0000000002, 'Yuri Jatki', 'jatki', '202cb962ac59075b964b07152d234b70', 'yuri_jatki@estudante.sc.senai.br', '1995-02-20', 'M', 'E', 0, 0, ''),
(0000000003, 'Amanda Alves', 'fairypanda', '202cb962ac59075b964b07152d234b70', 'amanda_alves@estudante.sc.senai.br', '1996-02-20', 'F', 'E', 0, 0, ''),
(0000000004, 'João Trugilo', 'trugilocolt', '202cb962ac59075b964b07152d234b70', 'joao_trugilo@estudante.sc.senai.br', '1999-02-20', 'M', 'E', 0, 0, ''),
(0000000005, 'Wilson Marutti', 'wilsinho', '202cb962ac59075b964b07152d234b70', 'wilson_marutti@estudante.sc.senai.br', '1996-02-20', 'M', 'E', 0, 0, ''),
(0000000006, 'Vinicius Lima', 'liminha', '202cb962ac59075b964b07152d234b70', 'vinicius_lima@estudante.sc.senai.br', '2001-02-20', 'M', 'E', 0, 0, ''),
(0000000007, 'Cleiton Souza', 'cleitin', '202cb962ac59075b964b07152d234b70', 'cleiton_souza@estudante.sc.senai.br', '1994-02-20', 'M', 'E', 0, 0, ''),
(0000000008, 'Luis Meneghim', 'meneghim', '202cb962ac59075b964b07152d234b70', 'luis_meneguim@estudante.sc.senai.br', '1978-02-20', 'M', 'E', 0, 0, ''),
(0000000009, 'Jean Capote', 'capotinhojc', '202cb962ac59075b964b07152d234b70', 'jean_capote@estudante.sc.senai.br', '1988-02-20', 'M', 'P', 0, 0, ''),
(0000000010, 'Maicol Peterson', 'helicopterinho', '202cb962ac59075b964b07152d234b70', 'maicol_peterson@estudante.sc.senai.br', '1980-02-20', 'M', 'P', 0, 0, ''),
(0000000011, 'Melrulim Lourenzetti', 'mel', '202cb962ac59075b964b07152d234b70', 'melrulim_lz@estudante.sc.senai.br', '1985-02-20', 'F', 'P', 0, 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_has_atividades`
--

CREATE TABLE `usuarios_has_atividades` (
  `usuarios_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário que possui atividades.',
  `atividades_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID das atividades dos usuários.',
  `status` int(11) NOT NULL COMMENT 'Verifica se a atividade foi concluída'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar todas as atividades dos usuários.';

--
-- Extraindo dados da tabela `usuarios_has_atividades`
--

INSERT INTO `usuarios_has_atividades` (`usuarios_id`, `atividades_id`, `status`) VALUES
(0000000001, 0000000002, 0),
(0000000001, 0000000003, 0),
(0000000001, 0000000004, 0),
(0000000002, 0000000002, 0),
(0000000002, 0000000003, 0),
(0000000002, 0000000004, 0),
(0000000003, 0000000002, 0),
(0000000003, 0000000003, 0),
(0000000003, 0000000004, 0),
(0000000004, 0000000002, 0),
(0000000004, 0000000003, 0),
(0000000004, 0000000004, 0),
(0000000005, 0000000006, 0),
(0000000005, 0000000007, 0),
(0000000006, 0000000006, 0),
(0000000006, 0000000007, 0),
(0000000006, 0000000008, 0),
(0000000007, 0000000006, 0),
(0000000007, 0000000007, 0),
(0000000008, 0000000006, 0),
(0000000008, 0000000007, 0),
(0000000009, 0000000002, 0),
(0000000009, 0000000003, 0),
(0000000009, 0000000004, 0),
(0000000009, 0000000005, 0),
(0000000009, 0000000006, 0),
(0000000009, 0000000007, 0),
(0000000010, 0000000002, 0),
(0000000010, 0000000003, 0),
(0000000010, 0000000004, 0),
(0000000011, 0000000002, 0),
(0000000011, 0000000003, 0),
(0000000011, 0000000004, 0),
(0000000011, 0000000006, 0),
(0000000011, 0000000007, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_has_grupos`
--

CREATE TABLE `usuarios_has_grupos` (
  `usuarios_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID dos usuários que pertencem aos grupos.',
  `grupos_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID dos grupos que os usuários estão inseridos.',
  `permissao` tinyint(1) NOT NULL COMMENT 'Serve para verificar a categoria do usuário no grupo (administrador ou integrante).',
  `status` tinyint(1) NOT NULL COMMENT 'Serve para verificar se o usuário está ativo no grupo ou não.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar os grupos que os usuários estão inseridos.';

--
-- Extraindo dados da tabela `usuarios_has_grupos`
--

INSERT INTO `usuarios_has_grupos` (`usuarios_id`, `grupos_id`, `permissao`, `status`) VALUES
(0000000001, 0000000001, 0, 1),
(0000000002, 0000000001, 0, 1),
(0000000003, 0000000001, 0, 1),
(0000000004, 0000000001, 0, 1),
(0000000005, 0000000002, 0, 1),
(0000000006, 0000000002, 0, 1),
(0000000007, 0000000002, 0, 1),
(0000000008, 0000000002, 0, 1),
(0000000009, 0000000001, 1, 1),
(0000000009, 0000000002, 1, 1),
(0000000010, 0000000001, 0, 0),
(0000000011, 0000000001, 0, 0),
(0000000011, 0000000002, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_has_interesses`
--

CREATE TABLE `usuarios_has_interesses` (
  `usuarios_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID do usuário que possui interesses.',
  `interesses_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'ID dos interesses dos usuários.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar os interesses dos usuários.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_has_usuarios`
--

CREATE TABLE `usuarios_has_usuarios` (
  `usuarios_id` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Usuário que possui amigo.',
  `usuarios_idamigos` int(10) UNSIGNED ZEROFILL NOT NULL COMMENT 'Usuário que é o amigo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabela para armazenar lista de amigos.';

--
-- Extraindo dados da tabela `usuarios_has_usuarios`
--

INSERT INTO `usuarios_has_usuarios` (`usuarios_id`, `usuarios_idamigos`) VALUES
(0000000009, 0000000001),
(0000000009, 0000000002),
(0000000009, 0000000003),
(0000000009, 0000000004),
(0000000009, 0000000005),
(0000000009, 0000000006),
(0000000009, 0000000007),
(0000000009, 0000000008),
(0000000009, 0000000010),
(0000000009, 0000000011);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome`),
  ADD KEY `fk_grupos_interesses1_idx` (`interesses_id`);

--
-- Índices para tabela `grupos_has_atividades`
--
ALTER TABLE `grupos_has_atividades`
  ADD PRIMARY KEY (`atividades_id`,`grupos_id`),
  ADD KEY `fk_grupos_has_atividades_atividades1_idx` (`atividades_id`),
  ADD KEY `fk_grupos_has_atividades_grupos1_idx` (`grupos_id`);

--
-- Índices para tabela `interesses`
--
ALTER TABLE `interesses`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_UNIQUE` (`usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Índices para tabela `usuarios_has_atividades`
--
ALTER TABLE `usuarios_has_atividades`
  ADD PRIMARY KEY (`usuarios_id`,`atividades_id`),
  ADD KEY `fk_usuarios_has_atividades_atividades1_idx` (`atividades_id`),
  ADD KEY `fk_usuarios_has_atividades_usuarios1_idx` (`usuarios_id`);

--
-- Índices para tabela `usuarios_has_grupos`
--
ALTER TABLE `usuarios_has_grupos`
  ADD PRIMARY KEY (`usuarios_id`,`grupos_id`),
  ADD KEY `fk_usuarios_has_grupos_grupos1_idx` (`grupos_id`),
  ADD KEY `fk_usuarios_has_grupos_usuarios_idx` (`usuarios_id`);

--
-- Índices para tabela `usuarios_has_interesses`
--
ALTER TABLE `usuarios_has_interesses`
  ADD PRIMARY KEY (`usuarios_id`,`interesses_id`),
  ADD KEY `fk_usuarios_has_interesses_interesses1_idx` (`interesses_id`),
  ADD KEY `fk_usuarios_has_interesses_usuarios1_idx` (`usuarios_id`);

--
-- Índices para tabela `usuarios_has_usuarios`
--
ALTER TABLE `usuarios_has_usuarios`
  ADD PRIMARY KEY (`usuarios_id`,`usuarios_idamigos`),
  ADD KEY `fk_usuarios_has_usuarios_usuarios2_idx` (`usuarios_idamigos`),
  ADD KEY `fk_usuarios_has_usuarios_usuarios1_idx` (`usuarios_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID da atividade.', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do grupo.', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `interesses`
--
ALTER TABLE `interesses`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do interesse.', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'ID do usuário.', AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `fk_grupos_interesses1` FOREIGN KEY (`interesses_id`) REFERENCES `interesses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `grupos_has_atividades`
--
ALTER TABLE `grupos_has_atividades`
  ADD CONSTRAINT `fk_grupos_has_atividades_atividades1` FOREIGN KEY (`atividades_id`) REFERENCES `atividades` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_grupos_has_atividades_grupos1` FOREIGN KEY (`grupos_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios_has_atividades`
--
ALTER TABLE `usuarios_has_atividades`
  ADD CONSTRAINT `fk_usuarios_has_atividades_atividades1` FOREIGN KEY (`atividades_id`) REFERENCES `atividades` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_atividades_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios_has_grupos`
--
ALTER TABLE `usuarios_has_grupos`
  ADD CONSTRAINT `fk_usuarios_has_grupos_grupos1` FOREIGN KEY (`grupos_id`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_grupos_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios_has_interesses`
--
ALTER TABLE `usuarios_has_interesses`
  ADD CONSTRAINT `fk_usuarios_has_interesses_interesses1` FOREIGN KEY (`interesses_id`) REFERENCES `interesses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_interesses_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios_has_usuarios`
--
ALTER TABLE `usuarios_has_usuarios`
  ADD CONSTRAINT `fk_usuarios_has_usuarios_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_has_usuarios_usuarios2` FOREIGN KEY (`usuarios_idamigos`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
