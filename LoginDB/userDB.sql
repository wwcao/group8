
CREATE DATABASE IF NOT EXISTS `userDB`;
USE `userDB`;

DROP TABLE IF EXISTS `groupmembers`;
DROP TABLE IF EXISTS `groups`;


CREATE TABLE IF NOT EXISTS `users` (
  `id` 							int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` 				varchar(50) NOT NULL,
  `password` 				varchar(100) NOT NULL,
  `auth_key` 				varchar(100) NOT NULL,
  `access_token` 		varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `profiles` (
	`username` varchar(50) NOT NULL,
	`lastname` varchar(20),
	`firstname` varchar(20),
	`email` varchar(50),
	`phone_num`	varchar(10),
	PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `groups` (
	`groupname`	varchar(50) NOT NULL,
	`l_user` varchar(50) NOT NULL,
	`description` text NOT NULL,
	`create_date`	DATE,
	`status` varchar(1) check (`status` = 'c' or `status`='o'),
	PRIMARY KEY (`groupname`,`l_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `groupmembers` (
	`groupname`	varchar(50),
	`l_user` varchar(50),
	`m_user` varchar(50) NOT NULL,
	PRIMARY KEY (`groupname`,`l_user`, `m_user`),
	FOREIGN KEY (`groupname`,`l_user`) REFERENCES `groups`(`groupname`,`l_user`)
	on delete cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `interest` (
	`username` varchar(50) NOT NULL,
	`interest` varchar(15) NOT NULL,
	PRIMARY KEY (`username`, `interest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
