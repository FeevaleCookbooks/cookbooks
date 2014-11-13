-- Database Modification SQL Script
-- Please don't forget to backup your data!



#####################################################################
####################### Tables changes ##############################
#####################################################################


-- ------------ --
-- Added tables --
-- ------------ --
CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cidade` varchar(255),
  `profissao` varchar(255),
  `foto` varchar(255),
  `observacao` text,
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_usuario`)
)
ENGINE=INNODB;

CREATE TABLE `receita` (
  `id_receita` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `categoria` int(11) DEFAULT '0',
  `nome` varchar(255),
  `ingredientes` text,
  `modo_preparo` text,
  `categoria` varchar(255),
  `foto` varchar(255),
  `observacao` text,
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_receita`)
)
ENGINE=INNODB;

CREATE TABLE `comentario` (
  `id_comentario` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `id_receita` int(11) NOT NULL DEFAULT '0',
  `comentario` text,
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_comentario`)
)
ENGINE=INNODB;

CREATE TABLE `like` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `id_receita` int(11) NOT NULL DEFAULT '0',
  `ativo` tinyint(4),
  PRIMARY KEY(`id_like`)
)
ENGINE=INNODB;

CREATE TABLE `denuncia` (
  `id_denuncia` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_criador` int(11) NOT NULL DEFAULT '0',
  `id_usuario` int(11) DEFAULT '0',
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `id_receita` int(11) NOT NULL DEFAULT '0',
  `denuncia` text,
  `status` varchar(100),
  PRIMARY KEY(`id_denuncia`)
)
ENGINE=INNODB;

CREATE TABLE `seguidor` (
  `id_seguidor` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_seguidor` int(11) NOT NULL DEFAULT '0',
  `id_usuario_seguido` int(11) NOT NULL DEFAULT '0',
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_seguidor`)
)
ENGINE=INNODB;

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255),
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_categoria`)
)
ENGINE=INNODB;



-- ----------------------------- --
-- Foreign keys for added tables --
-- ----------------------------- --


ALTER TABLE `receita` ADD
  CONSTRAINT `Ref_01` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `receita` ADD
  CONSTRAINT `Ref_12` FOREIGN KEY (`categoria`)
    REFERENCES `categoria`(`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;


ALTER TABLE `comentario` ADD
  CONSTRAINT `Ref_02` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `comentario` ADD
  CONSTRAINT `Ref_03` FOREIGN KEY (`id_receita`)
    REFERENCES `receita`(`id_receita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;


ALTER TABLE `like` ADD
  CONSTRAINT `Ref_04` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `like` ADD
  CONSTRAINT `Ref_05` FOREIGN KEY (`id_receita`)
    REFERENCES `receita`(`id_receita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;


ALTER TABLE `denuncia` ADD
  CONSTRAINT `Ref_06` FOREIGN KEY (`id_usuario_criador`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `denuncia` ADD
  CONSTRAINT `Ref_07` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `denuncia` ADD
  CONSTRAINT `Ref_08` FOREIGN KEY (`id_comentario`)
    REFERENCES `comentario`(`id_comentario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `denuncia` ADD
  CONSTRAINT `Ref_09` FOREIGN KEY (`id_receita`)
    REFERENCES `receita`(`id_receita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;


ALTER TABLE `seguidor` ADD
  CONSTRAINT `Ref_10` FOREIGN KEY (`id_usuario_seguidor`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

ALTER TABLE `seguidor` ADD
  CONSTRAINT `Ref_11` FOREIGN KEY (`id_usuario_seguido`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;


