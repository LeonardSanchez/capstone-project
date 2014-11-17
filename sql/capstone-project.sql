-- event site group 2 create tables
-- sandoval, sebastian
-- mistalski, james
-- slevin, brendan
-- sanchez, leonard
--
--

DROP TABLE IF EXISTS ticket;
DROP TABLE IF EXISTS transaction;
DROP TABLE IF EXISTS barcode;
DROP TABLE IF EXISTS eventLink;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS venue;
DROP TABLE IF EXISTS eventCategory;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS user;

-- create user table
CREATE TABLE user (

	-- PRIMARY KEY
   userId         	INT UNSIGNED AUTO_INCREMENT    NOT NULL,
   email          	VARCHAR (128)                  NOT NULL,
   passwordHash   	VARCHAR (128)                  NOT NULL,
   salt           	VARCHAR (64)                   NOT NULL,
   authToken      	VARCHAR (32)                   NOT NULL,
	-- PRIMARY KEY
	PRIMARY KEY(userId),
	-- indexed for login
	UNIQUE(email)
);


CREATE TABLE profile (
	-- PRIMARY KEY
   profileId  			INT UNSIGNED AUTO_INCREMENT   NOT NULL,
	-- FOREIGN KEY
   userId     			INT UNSIGNED                  NOT NULL,
   firstName    		VARCHAR(32)                 	NOT NULL,
   lastName     		VARCHAR(32)                 	NOT NULL,
   dateOfBirth  		DATE			                 	NOT NULL,
   gender       		CHAR									NOT NULL,

	-- PRIMARY KEY
   PRIMARY KEY(profileId),
	-- FOREIGN KEY
   UNIQUE (userId),
   FOREIGN KEY (userId) REFERENCES user (userId)
);

-- create eventCategory table
CREATE TABLE eventCategory(
	-- PRIMARY KEY
	eventCategoryId INT UNSIGNED NOT NULL AUTO_INCREMENT,
	-- not indexing because it will be searched by eventCategoryId
	eventCategory VARCHAR(50),
	PRIMARY KEY(eventCategoryId)
);

-- create venue table
CREATE TABLE venue (
	-- PRIMARY KEY
	venueId 			INT UNSIGNED NOT NULL AUTO_INCREMENT,
	-- indexed for searching
	venueName 		VARCHAR(100) NOT NULL,
	venueCapacity 	INT UNSIGNED NOT NULL,
	venuePhone 		VARCHAR(20) NOT NULL,
	venueWebsite 	VARCHAR(250) NOT NULL,
	venueAddress1 		VARCHAR(50) NOT NULL,
	venueAddress2 		VARCHAR(30) NULL,

	-- indexed for searching
	venueCity 			VARCHAR(25) NOT NULL,
	venueState 			CHAR(2) NOT NULL,
	venueZipCode 		VARCHAR(11) NOT NULL,
	--

	-- PRIMARY KEY
	PRIMARY KEY (venueId),
	-- search INDEX
	INDEX (venueName),
	INDEX (venueCity),
	INDEX (venueState)
	--
);

-- create eventLink table
CREATE TABLE eventLink(

-- FOREIGN KEY
	eventCategoryId INT UNSIGNED NOT NULL,

-- FOREIGN KEY
	eventId INT UNSIGNED NOT NULL,

-- Indexing for foreign keys
	UNIQUE(eventCategoryId),
	UNIQUE(eventId),

-- calling to tables with foreign keys
	FOREIGN KEY(eventCategoryId) REFERENCES eventCategory(eventCategoryId),
	FOREIGN KEY(eventId) REFERENCES event(eventId)
);

-- create event table
CREATE TABLE event (

-- PRIMARY KEY
	eventId 				INT UNSIGNED AUTO_INCREMENT NOT NULL ,
-- FOREIGN KEY
	eventCategoryId 	INT UNSIGNED NOT NULL,
-- FOREIGN KEY
	venueId 				INT UNSIGNED NOT NULL,
	eventName 			VARCHAR(100) NOT NULL,
	eventDateTime 		DATETIME NOT NULL,
	ticketPrice 		DECIMAL(9,2),

-- assign primary key
	PRIMARY KEY(eventId),

-- indexing eventName because it will be commonly searched
	INDEX(eventName),

-- indexing eventDateTime because it will have its own search function
	INDEX(eventDateTime),

-- unique index for foreign key
	UNIQUE(eventCategoryId),
	UNIQUE(venueId),

-- call the foreign keys tables
	FOREIGN KEY(eventCategoryId) REFERENCES eventLink(eventCategoryId),
	FOREIGN KEY(venueId) REFERENCES venue(venueId)
);


-- milestone project
-- create barcode table
CREATE TABLE barcode (
   barcodeId 		INT UNSIGNED AUTO_INCREMENT NULL,
   PRIMARY KEY(barcodeId)           
);

-- create transaction table
CREATE TABLE transaction (
	-- PRIMARY KEY
   transactionId 	INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- FOREIGN KEY
	profileId 		INT UNSIGNED NOT NULL,
   amount 			DECIMAL(9, 2) UNSIGNED NOT NULL,
   dateApproved 	DATETIME NOT NULL,
--	cardToken 		VARCHAR(128) NOT NULL,
--	customerToken 	VARCHAR(35) NOT NULL,
	-- indexing for foreign key
	UNIQUE(profileId),
   PRIMARY KEY(transactionId),
	-- call to profile table for foreign key
   FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

-- create ticket table
CREATE TABLE ticket (
-- PRIMARY KEY
	ticketId 		INT UNSIGNED NOT NULL AUTO_INCREMENT,
-- FOREIGN KEY
	profileId 		INT UNSIGNED NOT NULL,
-- FOREIGN KEY
	eventId 			INT UNSIGNED NOT NULL,
-- FOREIGN KEY
	transactionId 	INT UNSIGNED NOT NULL,
-- seat 				VARCHAR(10),
	barcodeId 		INT UNSIGNED,

	PRIMARY KEY (ticketId),
-- indexing for foreign keys
	UNIQUE(profileId),
	UNIQUE(eventId),
	UNIQUE(transactionId),
	UNIQUE(barcodeId),
-- calling to profile, event, transaction, and barcode tables
	FOREIGN KEY (profileId) REFERENCES profile(profileId),
	FOREIGN KEY (eventId) REFERENCES event(eventId),
	FOREIGN KEY (transactionId) REFERENCES transaction(transactionId),
	FOREIGN KEY (barcodeId) REFERENCES barcode(barcodeId)
);
