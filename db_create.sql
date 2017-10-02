DROP DATABASE DealerInspireTest;

CREATE DATABASE DealerInspireTest;

use DealerInspireTest;

CREATE TABLE ContactForm(
	ID int NOT NULL AUTO_INCREMENT,
	FullName varchar(255) NOT NULL,
	EmailAddress varchar(255) NOT NULL,
	PhoneNumber varchar(15),
	Message longtext,
	ContactDate datetime DEFAULT NOW( ),
	PRIMARY KEY (ID) 
);