DROP DATABASE IF EXISTS gtube
;

CREATE DATABASE IF NOT EXISTS gtube
;

USE gtube
;

DROP TABLE IF EXISTS webusers
;

CREATE TABLE `webusers` (
  `webUserID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(40) NOT NULL,
  `pass` varchar(300) NOT NULL,
  `privateSalt` varchar(7) NOT NULL,
  `token` varchar(20) NOT NULL,
  PRIMARY KEY (`webUserID`),
  UNIQUE KEY `userName` (`userName`,`token`)
);

DROP USER 'webuser'
;

FLUSH PRIVILEGES
;

CREATE USER 'webuser'@'localhost'
IDENTIFIED BY 'webuser'
;

GRANT USAGE, SELECT, INSERT, UPDATE, DELETE, INDEX ON gtube.webusers TO webuser
;

FLUSH PRIVILEGES
;