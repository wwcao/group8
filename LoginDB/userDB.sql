SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS userDB; 
USE userDB;

CREATE TABLE IF NOT EXISTS users (
	username 	varchar(45) DEFAULT NULL,
	password 	varchar(100) DEFAULT NULL,
	email 	varchar(100) DEFAULT NULL,
  PRIMARY KEY (username)
);

INSERT INTO users (username, password, email) VALUES
('admin', 'admin', NULL);

