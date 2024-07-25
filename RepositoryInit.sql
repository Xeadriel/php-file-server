CREATE TABLE IF NOT EXISTS Main.Users (
	ID int NOT NULL AUTO_INCREMENT UNIQUE,
    username varchar(255) NOT NULL UNIQUE,
    pass varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
	PRIMARY KEY (ID)
); 