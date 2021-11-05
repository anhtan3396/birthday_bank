DROP DATABASE Infomation;
CREATE DATABASE Infomation CHARACTER SET UTF8;
USE Infomation;

CREATE TABLE Users
(
	Id				INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Username		VARCHAR(100),
    Name			VARCHAR(100),
    Password		VARCHAR(100),
    DOB				varchar(50),
	Date_created	varchar(50),
    CONSTRAINT UC_Users_Username UNIQUE(Username)
   
);

INSERT INTO Users VALUES (NULL, 'admin', 'Phuong', 'admin', '12-25-1997', '07-07-2017');

