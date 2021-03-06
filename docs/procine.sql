# SQL Manager 2007 for MySQL 4.1.2.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : mregis_procine


SET FOREIGN_KEY_CHECKS=0;

#
# Structure for the `grupo` table :
#

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(255) default NULL,
  `descricao` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `permissao` table :
#

DROP TABLE IF EXISTS `permissao`;

CREATE TABLE `permissao` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(255) default NULL,
  `descricao` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `grupo_permissao` table :
#

DROP TABLE IF EXISTS `grupo_permissao`;

CREATE TABLE `grupo_permissao` (
  `grupo_id` int(11) NOT NULL default '0',
  `permissao_id` int(11) NOT NULL default '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`grupo_id`,`permissao_id`),
  KEY `grupo_permissao_permissao_id_permissao_id` (`permissao_id`),
  CONSTRAINT `grupo_permissao_grupo_id_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grupo_permissao_permissao_id_permissao_id` FOREIGN KEY (`permissao_id`) REFERENCES `permissao` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `usuario` table :
#

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `nome_acesso` varchar(128) NOT NULL,
  `algoritmo` varchar(128) NOT NULL default 'sha1',
  `salt` varchar(128) default NULL,
  `senha` varchar(128) default NULL,
  `status` int(11) default '1',
  `super_admin` tinyint(1) default '0',
  `ultimo_login` datetime default NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(11) default '0',
  `data_nascimento` datetime default '0000-00-00 00:00:00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nome_acesso` (`nome_acesso`),
  KEY `is_active_idx_idx` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `remember_key` table :
#

DROP TABLE IF EXISTS `remember_key`;

CREATE TABLE `remember_key` (
  `id` int(11) NOT NULL auto_increment,
  `usuario_id` int(11) default NULL,
  `remember_key` varchar(32) default NULL,
  `ip` varchar(50) NOT NULL default '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`,`ip`),
  KEY `usuario_id_idx` (`usuario_id`),
  CONSTRAINT `remember_key_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `usuario_grupo` table :
#

DROP TABLE IF EXISTS `usuario_grupo`;

CREATE TABLE `usuario_grupo` (
  `usuario_id` int(11) NOT NULL default '0',
  `grupo_id` int(11) NOT NULL default '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`usuario_id`,`grupo_id`),
  KEY `usuario_grupo_grupo_id_grupo_id` (`grupo_id`),
  CONSTRAINT `usuario_grupo_grupo_id_grupo_id` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usuario_grupo_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Structure for the `usuario_permissao` table :
#

DROP TABLE IF EXISTS `usuario_permissao`;

CREATE TABLE `usuario_permissao` (
  `usuario_id` int(11) NOT NULL default '0',
  `permissao_id` int(11) NOT NULL default '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`usuario_id`,`permissao_id`),
  KEY `usuario_permissao_permissao_id_permissao_id` (`permissao_id`),
  CONSTRAINT `usuario_permissao_permissao_id_permissao_id` FOREIGN KEY (`permissao_id`) REFERENCES `permissao` (`id`) ON DELETE CASCADE,
  CONSTRAINT `usuario_permissao_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for the `grupo` table  (LIMIT 0,500)
#

INSERT INTO `grupo` (`id`, `nome`, `descricao`, `created_at`, `updated_at`) VALUES
  (2,'administradores','Grupo Administradores','2010-06-04 00:21:42','2010-06-04 00:21:42');

COMMIT;

#
# Data for the `permissao` table  (LIMIT 0,500)
#

INSERT INTO `permissao` (`id`, `nome`, `descricao`, `created_at`, `updated_at`) VALUES
  (2,'administrador','Permiss?o de Administrador','2010-06-04 00:21:42','2010-06-04 00:21:42');

COMMIT;

#
# Data for the `grupo_permissao` table  (LIMIT 0,500)
#

INSERT INTO `grupo_permissao` (`grupo_id`, `permissao_id`, `created_at`, `updated_at`) VALUES
  (2,2,'2010-06-04 00:21:42','2010-06-04 00:21:42');

COMMIT;

#
# Data for the `usuario` table  (LIMIT 0,500)
#

INSERT INTO `usuario` (`id`, `nome_acesso`, `algoritmo`, `salt`, `senha`, `status`, `super_admin`, `ultimo_login`, `nome`, `email`, `cpf`, `data_nascimento`, `created_at`, `updated_at`) VALUES
  (2,'procine_admin','sha1','6056ebc6ca5ceacbdc9819896123ab88','07ac76446e9d0a21b68006a3ade6f49333f66cd4',1,1,'2010-06-04 00:48:54','Administrador Procine','marcos@marcosregis.com','19753626835','0000-00-00','2010-06-04 00:21:42','2010-06-04 00:48:54');

COMMIT;

#
# Data for the `usuario_grupo` table  (LIMIT 0,500)
#

INSERT INTO `usuario_grupo` (`usuario_id`, `grupo_id`, `created_at`, `updated_at`) VALUES
  (2,2,'2010-06-04 00:21:42','2010-06-04 00:21:42');

COMMIT;

