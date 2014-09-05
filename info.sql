/*
Navicat MySQL Data Transfer

Source Server         : _localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : info

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-03-29 22:34:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_categoria`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_categoria`;
CREATE TABLE `tbl_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_categoria
-- ----------------------------
INSERT INTO `tbl_categoria` VALUES ('1', 'Internet', '1');
INSERT INTO `tbl_categoria` VALUES ('2', 'Mouse', '1');
INSERT INTO `tbl_categoria` VALUES ('3', 'Impressora', '1');
INSERT INTO `tbl_categoria` VALUES ('4', 'Monitor', '1');
INSERT INTO `tbl_categoria` VALUES ('5', 'Desktop', '1');

-- ----------------------------
-- Table structure for `tbl_chamado`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_chamado`;
CREATE TABLE `tbl_chamado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `descricao` text,
  `id_user` int(11) DEFAULT NULL,
  `id_user_resolve` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `descricao_solucao` text,
  `notificado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_chamado
-- ----------------------------
INSERT INTO `tbl_chamado` VALUES ('1', '1', '2', 'teste', '10', '1', '1', null, '1');
INSERT INTO `tbl_chamado` VALUES ('2', '4', '5', 'teste', '10', '1', '2', 'teste', '1');
INSERT INTO `tbl_chamado` VALUES ('3', '4', '5', 'teste', '10', '1', '2', 'tela consertada', '1');
INSERT INTO `tbl_chamado` VALUES ('4', '1', '2', 'teste', '10', '1', '2', 'em tratamento', '1');
INSERT INTO `tbl_chamado` VALUES ('5', '4', '5', 'teste3', '10', '1', '2', 'teste', '1');
INSERT INTO `tbl_chamado` VALUES ('6', '5', '6', 'mais um problema', '10', '1', '2', 'user burro', '1');
INSERT INTO `tbl_chamado` VALUES ('7', '2', '4', 'teste', '2', '1', '2', 'teste', '1');
INSERT INTO `tbl_chamado` VALUES ('8', '4', '5', 'teste', '2', '1', '3', 'teste', '1');

-- ----------------------------
-- Table structure for `tbl_indisponibilidade`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_indisponibilidade`;
CREATE TABLE `tbl_indisponibilidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `descricao` text,
  `data_problema` varchar(255) DEFAULT NULL,
  `data_resolucao` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_indisponibilidade
-- ----------------------------
INSERT INTO `tbl_indisponibilidade` VALUES ('1', '2', '2', 'teste', '28/02/2014', null, '1');
INSERT INTO `tbl_indisponibilidade` VALUES ('2', '2', '2', 'teste', '28/02/2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('3', '2', '2', 'teste', '28/02/2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('4', '1', '1', 'teste', '28/02/2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('5', '1', '2', 'teste de indisponibilidade', '28-02-2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('6', '1', '1', 'problemas com internet', '28-02-2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('7', '4', '5', 'teste de reportabilidade', '28-02-2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('8', '1', '1', 'teste', '28-02-2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('9', '3', '3', 'teste', '28-02-2014', '28-02-2014', '2');
INSERT INTO `tbl_indisponibilidade` VALUES ('10', '1', '1', 'geral', '21-03-2014', '21-03-2014', '2');

-- ----------------------------
-- Table structure for `tbl_nivel`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_nivel`;
CREATE TABLE `tbl_nivel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_nivel
-- ----------------------------
INSERT INTO `tbl_nivel` VALUES ('1', 'Odin', '1');
INSERT INTO `tbl_nivel` VALUES ('2', 'Thor', '1');
INSERT INTO `tbl_nivel` VALUES ('3', 'Laufey', '1');

-- ----------------------------
-- Table structure for `tbl_notificacao`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_notificacao`;
CREATE TABLE `tbl_notificacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chamado` int(11) DEFAULT NULL,
  `id_user_chamado` int(11) DEFAULT NULL,
  `novo_chamado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_notificacao
-- ----------------------------
INSERT INTO `tbl_notificacao` VALUES ('1', '1', '10', '0');
INSERT INTO `tbl_notificacao` VALUES ('2', '2', '10', '0');
INSERT INTO `tbl_notificacao` VALUES ('3', '3', '0', '0');
INSERT INTO `tbl_notificacao` VALUES ('4', '4', '10', '0');
INSERT INTO `tbl_notificacao` VALUES ('5', '5', '10', '0');
INSERT INTO `tbl_notificacao` VALUES ('6', '6', '10', '0');
INSERT INTO `tbl_notificacao` VALUES ('7', '7', '2', '0');
INSERT INTO `tbl_notificacao` VALUES ('8', '8', '2', '0');

-- ----------------------------
-- Table structure for `tbl_setor`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_setor`;
CREATE TABLE `tbl_setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_setor
-- ----------------------------
INSERT INTO `tbl_setor` VALUES ('1', 'Informática', '1');
INSERT INTO `tbl_setor` VALUES ('2', 'Comercial', '1');
INSERT INTO `tbl_setor` VALUES ('3', 'Restritivos', '1');
INSERT INTO `tbl_setor` VALUES ('4', 'Físico-Mecânico', '1');
INSERT INTO `tbl_setor` VALUES ('5', 'Restritivos', '1');
INSERT INTO `tbl_setor` VALUES ('6', 'Biomecânica', '1');
INSERT INTO `tbl_setor` VALUES ('7', 'Administrativo', '1');
INSERT INTO `tbl_setor` VALUES ('8', 'Institucional', '1');

-- ----------------------------
-- Table structure for `tbl_subcategoria`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_subcategoria`;
CREATE TABLE `tbl_subcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_subcategoria
-- ----------------------------
INSERT INTO `tbl_subcategoria` VALUES ('1', '1', 'Sem Net', '1');
INSERT INTO `tbl_subcategoria` VALUES ('2', '1', 'Cabo Rompido', '1');
INSERT INTO `tbl_subcategoria` VALUES ('3', '3', 'Outro', '1');
INSERT INTO `tbl_subcategoria` VALUES ('4', '2', 'Leleca', '1');
INSERT INTO `tbl_subcategoria` VALUES ('5', '4', 'Tela Quebrada', '1');
INSERT INTO `tbl_subcategoria` VALUES ('6', '5', 'usuário burro', '1');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `id_setor` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_nivel` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'Roger', '1', 'roger@ibtec.org.br', 'd033e22ae348aeb5660fc2140aec35850c4da997', '1', '1');
INSERT INTO `tbl_user` VALUES ('2', 'Luan', '1', 'luan@ibtec.org.br', 'deb232860dc8da791ec5068d70657931f476ca11', '3', '1');
INSERT INTO `tbl_user` VALUES ('3', 'Ademir', '4', 'ademir@ibtec.org.br', 'd1c3b56aed25799af320f14f6f1874a8db013364', '3', '1');
