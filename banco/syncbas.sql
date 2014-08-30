-- Database Modification SQL Script
-- Please don't forget to backup your data!



#####################################################################
####################### Tables changes ##############################
#####################################################################


-- -------------- --
-- Changed tables --
-- -------------- --
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- `usuario` table changes
DROP TABLE IF EXISTS `_tmp_usuario`;

RENAME TABLE `usuario` TO `_tmp_usuario`;
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

INSERT INTO `usuario`(`id_usuario`)
SELECT `id_usuario` FROM `_tmp_usuario`;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


-- ------------ --
-- Added tables --
-- ------------ --
CREATE TABLE `receita` (
  `id_receita` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(255),
  `ingredientes` text,
  `modo_preparo` text,
  `categoria` varchar(255),
  `foto` varchar(255),
  `observacao` text,
  `ativo` tinyint(4) DEFAULT '1',
  PRIMARY KEY(`id_receita`)
)
ENGINE=MYISAM;



-- ----------------------------- --
-- Foreign keys for added tables --
-- ----------------------------- --

ALTER TABLE `receita` ADD
  CONSTRAINT `Ref_01` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;



-- ------------------------------- --
-- Foreign keys for changed tables --
-- ------------------------------- --
ALTER TABLE `receita` ADD
  CONSTRAINT `Ref_01` FOREIGN KEY (`id_usuario`)
    REFERENCES `usuario`(`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;

